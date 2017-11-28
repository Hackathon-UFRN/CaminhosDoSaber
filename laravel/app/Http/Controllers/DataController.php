<?php

namespace App\Http\Controllers;

use App\Widgets\CurlWidget;

class DataController extends Controller
{
    protected $curl = [
        'versao' => 'v0.1',
        'accept' => 'application/json;charset=UTF-8',
    ];

    public function index()
    {
        $cw = new CurlWidget();

        // Primeiro contato
        $response = $cw->first_contact();
        // Pegando as informações do Json retornado
        $jsonData = json_decode($response, true);

        // Iniciando consulta
        $this->curl['grupo'] = 'curso';
        $this->curl['consulta'] = 'cursos';
        $parametros = [
            'nivel' => 'G',
            "municipio" => "NATAL",
            'limit' => '10',
        ];
        $response = $cw->request($this->curl, $parametros, $jsonData);

        return view('data.index', [
            'response' => json_decode($response, true),
        ]);
    }

    public function dadosDiscente($cpf)
    {
        $cw = new CurlWidget();

        // Primeiro contato
        $response = $cw->first_contact();
        // Pegando as informações do Json retornado
        $jsonData = json_decode($response, true);

        // Iniciando consulta
        $this->curl['grupo'] = 'discente';
        $this->curl['consulta'] = 'discentes';
        $parametros = [
            'cpf-cnpj' => $cpf,
            'limit' => '10',
        ];

        //Pega apenas os cursos de graduação
        $dadosDiscente = collect(
                json_decode($cw->request($this->curl, $parametros, $jsonData), true)
            )->reject(function ($item){
                return $item['sigla-nivel'] != 'G';
            });

        return view('auth.historico.dadosDiscente', [
            'dadosDiscente' => collect(
                json_decode($dadosDiscente, true)
            )->sortBy('ano-ingresso'),
        ]);
    }
}
