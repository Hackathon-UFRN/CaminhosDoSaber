<?php

namespace App\Http\Controllers;

use App\Widgets\CurlWidget;
use Illuminate\Http\Request;

class EstruturaCurricularController extends Controller
{

    protected $curl = [
        'versao' => 'v0.1',
        'accept' => 'application/json;charset=UTF-8',
    ];

    /**
     * Retorna os componentes de um determinado curso.
     *
     * @param int $idCurso
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function componentesObrigatorios($matriculaDiscente)
    {
        //Recuperando discente
        $cwDiscente = new CurlWidget();

        $curlDiscente = $this->curl;
        $curlDiscente['grupo'] = 'discente';
        $curlDiscente['consulta'] = 'discentes';
        $parametrosDiscente = [
            'matricula' => $matriculaDiscente,
        ];

        $discente = json_decode(
            $cwDiscente->request($curlDiscente, $parametrosDiscente), true
        )[0];

        /*
        * Recuperando matriz curricular
        *
        * Infelizmente alguns cursos tem mais de uma matriz por
        * turno, ainda não achei jeito de ver como pegar o turno
        * que o aluno está matriculado
        */

        $cw = new CurlWidget();

        $curlMatriz = $this->curl;
        $curlMatriz['grupo'] = 'curso';
        $curlMatriz['consulta'] = 'matrizes-curriculares';

        $parametros = [
            'id-curso' => $discente['id-curso'],
            'ativo' => 'true',
        ];

        //Recuperando semestres cursados
        $cwSemestres = new CurlWidget();
        $curlSemestre = $this->curl;
        $curlSemestre['grupo'] = 'matricula';
        $curlSemestre['consulta'] = 'semestres-cursados';

        $parametrosSemestre = ['id-discente' => $discente['id-discente']];

        $semestres = json_decode(
            $cwSemestres->request($curlSemestre, $parametrosSemestre), true
        );

        //Inicializando pesquisa dos componentes
        $cwComponente = new CurlWidget();
        $curlComponente = $this->curl;
        $curlComponente['grupo'] = 'curso';
        $curlComponente['consulta'] = 'componentes-curriculares';

        //Estruturando matriz curricular
        $matrizesCurriculares = collect(json_decode(
            $cw->request($curlMatriz, $parametros), true
        ))->map(function ($matriz) use ($cwComponente, $curlComponente) {
            $parametrosComponente = [
                'id-matriz-curricular' => $matriz['id-matriz-curricular'],
                'disciplina-obrigatoria' => true,
            ];
            $componentes = $cwComponente->request(
                $curlComponente, $parametrosComponente
            );

            $matriz['componentes'] = $componentes;

            return $matriz;
        });

        /*
         * Isso aqui pega apenas as disciplinas dos semestres que o
         * cara já pagou. O problema é que a(s) matriz(es) que estão
         * sendo requisitadas nem sempre tem matérias obrigatórias nos
         * primeiros semestres.
         *
         *
         ->filter(function ($item) use ($semestres) {
            $componentes = json_decode($item['componentes'], true);

            return dd(collect($componentes)
                ->whereIn(
                    //Substituir [4,6] por collect($semestres)->pluck('periodo');
                    'semestre-oferta', [4,6]
                ));
        })
         * */

        return view('auth.estruturaCurricular.componentes', [
            'matrizesCurriculares' => json_decode($matrizesCurriculares, true),
            'semestres' => $semestres,
        ]);

    }
}
