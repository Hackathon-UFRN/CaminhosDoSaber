<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('App\Http\Middleware\CheckApiAcessToken');
    }

    /**
     * Gera a autenticação da API
     */
    public function loginUser()
    {
        return redirect(
            'https://apitestes.info.ufrn.br/authz-server/oauth/authorize?'
            .'client_id='.env('CLIENT_ID')
            .'&response_type=code&redirect_uri=http://localhost:8000/home'
        );
    }
}
