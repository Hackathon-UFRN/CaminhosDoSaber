<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check())
        return redirect('home');
    return redirect('login');
});

Auth::routes();
// Rotas para redirecionar usuario para a api e outra pro callback
Route::get('auth/api_ufrn', 'Auth\LoginController@redirectToApiUfrn');
// Teste do login do usuário
Route::get('auth/loginSigaa', 'Auth\LoginController@loginUser')->name('loginSigaa');

// Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/dadosUsuario', 'HomeController@dadosUsuario')->name('dadosUsuario');

    // Pegar dados da API
    Route::get('data', 'DataController@index')->name('data.index');
    Route::get('dadosDiscente/{cpf}', 'DataController@dadosDiscente')->name('dadosDiscente');

    //Retorna dados academicos do usuário logado
    Route::get('matriculasComponentes/{id}', 'AcademicsController@matriculasComponentes')
        ->name('academics.matriculasComponentes');
    Route::get('indicesDiscentes/{id}', 'AcademicsController@indicesDiscentes')
        ->name('academics.indicesDiscentes');

    //Retorna componentes curriculares de um determinado curso do aluno
    Route::get('componentesObrigatorios/{id}', 'EstruturaCurricularController@componentesObrigatorios')
        ->name('estruturaCurricular.componentesObrigatorios');

// });