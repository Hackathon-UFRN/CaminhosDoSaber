<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\CheckApiAcessToken');
    }

    /**
     * Recupera o código de autorização para a aplicacao
     * enviado pela sinfo e exibe o dashboard do aluno.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function dadosUsuario()
    {
        $usuarioAcessToken = session()->get('code');

        $curlConsulta = curl_init();
        curl_setopt_array($curlConsulta, array(
            CURLOPT_URL => "https://apitestes.info.ufrn.br/usuario/v0.1/usuarios/info",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . $usuarioAcessToken['token_type'] . " " . $usuarioAcessToken['access_token'],
                "x-api-key: " . env('X_API_KEY')
            ),
        ));

        $response = curl_exec($curlConsulta);
        $err = curl_error($curlConsulta);
        curl_close($curlConsulta);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return View::make('auth.historico.dadosUsuario', [
                'dadosUsuario' => json_decode($response, true),
            ]);
        }
    }
}
