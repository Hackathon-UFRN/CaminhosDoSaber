<?php

namespace App\Http\Controllers;

use App\Widgets\CurlWidget;

class AcademicsController extends Controller
{
    protected $curl = [
        'versao' => 'v0.1',
        'accept' => 'application/json;charset=UTF-8',
    ];

    /**
     * Consulta os componentes que o discente cursou.
     * Também é consultado suas notas e dados da turma para
     * conseguir retornar o nome do componente, melhor
     * identificação da turma e conseguir pegar as notas
     * das unidades.
     *
     * @param $idDiscente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function matriculasComponentes($idDiscente){
        $cw = new CurlWidget();
        $cwTurma = new CurlWidget();
        $cwNotas = new CurlWidget();

        $curlMatricula = $this->curl;
        $curlTurma = $this->curl;
        $curlNotasUnidade = $this->curl;

        $curlMatricula['grupo'] = 'matricula';
        $curlMatricula['consulta'] = 'matriculas-componentes';

        $curlTurma['grupo'] = 'turma';
        $curlTurma['consulta'] = 'turmas';

        $curlNotasUnidade['grupo'] = 'turma';
        $curlNotasUnidade['consulta'] = 'notas-unidades';


        $parametros = [
            'id-discente' => $idDiscente,
        ];

        $response = $cw->request($curlMatricula, $parametros);

        $matriculas = collect(json_decode($response, true))->map(
            function($item) use ($cwTurma, $curlTurma, $curlNotasUnidade, $idDiscente, $cwNotas){
                $curlTurma['parametro'] = $item['id-turma'];
                $parametrosNotas = [
                    'id-participante' => $idDiscente,
                    'id-turma' => $item['id-turma']
                ];

                $notas = json_decode($cwNotas->request($curlNotasUnidade, $parametrosNotas), true);
                $turma = json_decode($cwTurma->request($curlTurma), true);

                $item['nome-turma'] = 'Turma '.$turma['codigo-turma'].' - '.$turma['ano'];
                $item['nome-componente'] = $turma['nome-componente'];
                $item['unidades'] = $notas;


                return $item;
            }
        );

        return view('auth.historico.matriculasComponentes', [
            'matriculasComponentes' => json_decode($matriculas, true),
        ]);
    }

    /**
     * Retorna para a view os indices do discente
     *
     * @param $idDiscente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indicesDiscentes($idDiscente){
        $cwIndiceDiscente = new CurlWidget();
        $cwIndiceAcademico = new CurlWidget();

        $curlDiscente = $this->curl;
        $curlAcademico = $this->curl;

        $curlDiscente['grupo'] = 'discente';
        $curlDiscente['consulta'] = 'indices-discentes';

        $curlAcademico['grupo'] = 'discente';
        $curlAcademico['consulta'] = 'indices-academicos';

        $parametros = [
            'id-discente' => $idDiscente,
            'limit' => '10',
        ];
        //Recupera indices do discente
        $response = json_decode(
            $cwIndiceDiscente->request($curlDiscente, $parametros), true
        );

        //Recupera os indices da instituicao
        $indices = json_decode(
            $cwIndiceAcademico->request($curlAcademico), true
        );

        //Integrando os indices
        $indicesIntegralizados = collect($response)->merge(collect($indices))
            ->groupBy('id-indice-academico')
            ->reject(function ($item){
                return count($item) < 2;
            })->map(function ($item){
                return array_merge($item[0], $item[1]);
            });

        return view('auth.historico.indicesDiscentes', [
            'indicesDiscentes' => json_decode($indicesIntegralizados, true),
        ]);
    }

}
