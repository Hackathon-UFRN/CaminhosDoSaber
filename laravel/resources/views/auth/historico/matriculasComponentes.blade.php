@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Matriculas em componentes</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Faltas</th>
                                <th>Notas</th>
                                <th>Média final</th>
                                <th>Turma</th>
                                <th>Componente</th>
                                <th>Ano</th>
                                <th>Periodo</th>
                                <th>Recuperacao</th>
                                <th>Conceito</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($matriculasComponentes as $matricula)
                                <tr>
                                    <td>{{$matricula['faltas']}}</td>
                                    <td>
                                    @foreach($matricula['unidades'] as $unidade)
                                        {{ $unidade['media'] }} -
                                    @endforeach
                                    </td>
                                    <td>{{$matricula['media-final']}}</td>
                                    <td>{{$matricula['nome-turma']}}</td>
                                    <td>{{$matricula['nome-componente']}}</td>
                                    <td>{{$matricula['ano']}}</td>
                                    <td>{{$matricula['periodo']}}</td>
                                    <td>{{$matricula['recuperacao']}}</td>
                                    <td>{{$matricula['conceito']}}</td>
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
