@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dados do usuário</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id usuário</th>
                                    <th>Id unidade</th>
                                    <th>Login</th>
                                    <th>Nome da pessoa</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Ativo</th>
                                    <th>Email</th>
                                    <th>Id foto</th>
                                    <th>Chave foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$dadosUsuario['id-usuario']}}</td>
                                    <td>{{$dadosUsuario['id-unidade']}}</td>
                                    <td>{{$dadosUsuario['login']}}</td>
                                    <td>{{$dadosUsuario['nome-pessoa']}}</td>
                                    <td>{{$dadosUsuario['cpf-cnpj']}}</td>
                                    <td>{{$dadosUsuario['ativo']}}</td>
                                    <td>{{$dadosUsuario['email']}}</td>
                                    <td>{{$dadosUsuario['id-foto']}}</td>
                                    <td>{{$dadosUsuario['chave-foto']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{route('dadosDiscente', $dadosUsuario['cpf-cnpj'])}}" class="btn btn-primary btn-xs pull-right">Dados do discente</a>
                        {{-- <a href="{{ route('data.index') }}" class="btn btn-primary btn-xs pull-right">Componentes curriculares</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
