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
                                <th>Id discente</th>
                                <!-- <th>Nome do discente</th> -->
                                <!-- <th>CPF/CNPJ</th> -->
                                <th>Matricula</th>
                                <th>Id curso</th>
                                <th>Nome do curso</th>
                                <th>Nível do curso</th>
                                <th>Ano de ingresso</th>
                                <th>Período de ingresso</th>
                                <th>Opções</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dadosDiscente as $dados)
                                <tr>
                                    <td>{{$dados['id-discente']}}</td>
                                    <td>{{$dados['matricula']}}</td>
                                    <td>{{$dados['id-curso']}}</td>
                                    <td>{{$dados['nome-curso']}}</td>
                                    <td>{{$dados['sigla-nivel']}}</td>
                                    <td>{{$dados['ano-ingresso']}}</td>
                                    <td>{{$dados['periodo-ingresso']}}</td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a href="{{ route('academics.matriculasComponentes', $dados['id-discente']) }}" class="btn btn-xs btn-primary">
                                                Semestres cursados
                                            </a>
                                            <a href="{{ route('academics.indicesDiscentes', $dados['id-discente']) }}" class="btn btn-xs btn-danger">
                                                Índices acadêmicos
                                            </a>
                                            <a href="{{ route('estruturaCurricular.componentesObrigatorios', $dados['matricula']) }}" class="btn btn-xs btn-warning">
                                                Componentes a pagar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
