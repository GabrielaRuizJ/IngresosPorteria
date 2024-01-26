@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1>Administración de ciudades</h1>
@endsection
@section('content')
    @php
        $heads = [
            'ID','nombre del la ciudad','pais','' ];
    @endphp
<x-adminlte-button label="Nueva ciudad" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalciudad" class="float-right" />
<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach ($ciudades as $ciudad)
    <tr>
        <td>{{$ciudad->ciudad}}</td>
        <td>{{$ciudad->nombreciudad}}</td>
        <td>{{$ciudad->pais}}</td>
        <td><a href="{{route('ciudad.edit',['idc'=>$ciudad->ciudad,'idp'=>$ciudad->idpais])}}" class="btn btn-xs btn-default text-primary mx-1 shadow">
            <i class="fa fa-lg fa-fw fa-pen"></i>
        </a></td>
    </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="modalciudad" title="Agregar nueva ciudad" icon="fas fa-plus" size="lg">
    <form action="{{route('ciudad.create')}}" method="post">
        @csrf
        <div class="row">
            <x-adminlte-input name="nombre" required label="Nombre de la ciudad" placeholder="Colombia"/>
            <select name="id_pais" class="form-control">
                @foreach ($paises as $pais)
                    <option value="{{$pais->id}}">{{$pais->nombre_pais}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        <x-adminlte-button type="submit" label="Guardar pais" theme="primary" icon="fas fa-key"/>
    </form>
</x-adminlte-modal>
@endsection
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@endsection
@section('js')

@endsection