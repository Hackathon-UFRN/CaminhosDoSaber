<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class CheckApiAcessToken
{
    public $attributes;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('code'))
        {
            return $next($request);
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apitestes.info.ufrn.br"
                ."/authz-server/oauth/token?client_id=" .env('CLIENT_ID')
                ."&client_secret=".env('CLIENT_SECRET')
                ."&grant_type=client_credentials",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST"
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $apiResponse = "cURL Error #:" . $err;
            abort(404);
            //Se der erro faça alguma coisa, mas o que?
        } else {
            //Já transformar de json para array para extrair os dados
            //Que são: access_token, token_type, expires_in e scope
            $apiResponse = json_decode($response, true);
        }

        $request->attributes->add(
            ['apiResponse' => $apiResponse]
        );

        $http = new Client();
        $appCode = $request->get('code');

        if($appCode != null) {

            $response = $http->post(
                'https://apitestes.info.ufrn.br/authz-server/oauth/token?'
                . 'client_id=' . env('CLIENT_ID')
                . '&client_secret=' . env('CLIENT_SECRET')
                . '&redirect_uri=http://localhost:8000/home'
                . '&grant_type=authorization_code'
                . '&code=' . $appCode
            );

            $request->session()->put([
                'code' => \GuzzleHttp\json_decode((string)$response->getBody(), true)
            ]);
        }

        return $next($request);
    }
}
