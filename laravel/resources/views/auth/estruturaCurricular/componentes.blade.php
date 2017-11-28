@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Matriz Curricular e Componentes</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: darkslategrey; color: white">
                                    <th colspan="2">Semestres cursados</th>
                                </tr>
                                <tr style="background-color: forestgreen; color:white">
                                    <th>Ano</th>
                                    <th>Período</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semestres as $semestre)
                                <tr>
                                    <td>{{ $semestre['ano'] }}</td>
                                    <td>{{ $semestre['periodo'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach($matrizesCurriculares as $matriz)
                        <table class="table table-bordered">
                            <thead style="background-color: #1f648b; color:white">
                            <tr style="background-color: #122b40">
                                <td colspan="6">Matriz {{$loop->iteration}}</td>
                            </tr>
                            <tr>
                                <th>Ano</th>
                                <th>CH total minima</th>
                                <th>CH optativa minima</th>
                                <th>CH complementar minima</th>
                                <th>QTD semestres ideal</th>
                                <th>MAX semestres</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$matriz['ano']}}</td>
                                    <td>{{$matriz['ch-total-minima']}}</td>
                                    <td>{{$matriz['ch-optativas-minima']}}</td>
                                    <td>{{$matriz['ch-complementar-minima']}}</td>
                                    <td>{{$matriz['semestre-conclusao-ideal']}}</td>
                                    <td>{{$matriz['semestre-conclusao-maximo']}}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead style="margin-top: 45px; background-color: #5e5e5e; color:white" >
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo</th>
                                    <th>Nome</th>
                                    <th>Semestre de oferta</th>
                                    <th>CH</th>
                                    <th>Pre requisito</th>
                                    <th>Equivalentes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($matriz['componentes'], true) as $componente)
                                <tr>
                                    <td>{{ $componente['id-componente'] }}</td>
                                    <td>{{ $componente['codigo'] }}</td>
                                    <td>{{ $componente['nome'] }}</td>
                                    <td>{{ $componente['semestre-oferta'] }}</td>
                                    <td>{{ $componente['carga-horaria-total'] }}</td>
                                    <td>{{ $componente['pre-requisitos'] }}</td>
                                    <td>{{ $componente['equivalentes'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
