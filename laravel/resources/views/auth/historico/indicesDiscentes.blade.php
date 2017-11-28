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
                                    <th>Indice</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($indicesDiscentes as $indiceDiscente)
                                <tr>
                                    <td>{{$indiceDiscente['nome']}}</td>
                                    <td>{{$indiceDiscente['valor-indice']}}</td>
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
