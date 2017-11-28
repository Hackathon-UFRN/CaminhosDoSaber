<?php

namespace App\Widgets;

class CurlWidget
{
    protected $api = [
        'grant_type' => "client_credentials",
    ];

    public function first_contact()
    {
        $url = "http://apitestes.info.ufrn.br/authz-server/oauth/token?"
            ."client_id=".env('CLIENT_ID')
            ."&client_secret=".env('CLIENT_SECRET')
            ."&grant_type=".$this->api['grant_type'];

        /*
         * Primeiro contato
         */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST"
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function request($curl, $parametros = null, $jsonData = null)
    {
        if(count($curl) > 4)
        {
            $url = 'https://apitestes.info.ufrn.br/'
                .$curl['grupo'].'/'
                .$curl['versao'].'/'
                .$curl['consulta'].'/'
                .$curl['parametro'];
        }
        else
        {
            $url = 'https://apitestes.info.ufrn.br/'
                .$curl['grupo'].'/'
                .$curl['versao'].'/'
                .$curl['consulta'].'?';
        }

        if(!isset($jsonData))
        {
            $jsonData = session()->get('code');
        }

        if($parametros)
        {
            foreach ($parametros as $atributo => $valor)
                $url .= $atributo.'='.$valor.'&';
            $url = substr($url, 0, -1);
        }

        $curlConsulta = curl_init();
        curl_setopt_array($curlConsulta, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: ".$jsonData['token_type']." ".$jsonData['access_token'],
                "x-api-key: ".env('X_API_KEY'),
                "accept: ".$curl['accept']
            ],
        ));

        $response = curl_exec($curlConsulta);
        curl_close($curlConsulta);

        return $response;
    }
}
