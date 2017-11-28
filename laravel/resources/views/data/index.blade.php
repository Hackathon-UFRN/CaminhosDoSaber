@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Id componente</th>
                        <th>Codigo componente</th>
                        <th>Nome</th>
                        <th>Obrigatória</th>
                        <th>Semestre da oferta</th>
                        <th>Id da matriz curricular</th>
                        <th>Departamento</th>
                        <th>Carga Horária Total</th>
                        <th>Pre-requisito</th>
                        <th>Co-requisito</th>
                        <th>Equivalentes</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($response as $disciplina)
                        <tr>
                            <td>{{$disciplina['id-componente']}}</td>
                            <td>{{$disciplina['codigo']}}</td>
                            <td>{{$disciplina['nome']}}</td>
                            <td>{{$disciplina['disciplina-obrigatoria']}}</td>
                            <td>{{$disciplina['semestre-oferta']}}</td>
                            <td>{{$disciplina['id-matriz-curricular']}}</td>
                            <td>{{$disciplina['departamento']}}</td>
                            <td>{{$disciplina['carga-horaria-total']}}</td>
                            <td>{{$disciplina['pre-requisitos']}}</td>
                            <td>{{$disciplina['co-requisitos']}}</td>
                            <td>{{$disciplina['equivalentes']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
