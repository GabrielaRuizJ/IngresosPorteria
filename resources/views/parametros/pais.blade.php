@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1>Administración de paises</h1>
@endsection
@section('content')
    @php
        $heads = [
            'ID','nombre del país', ];
    @endphp
<x-adminlte-button label="Nuevo pais" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalpais" class="float-right" />
<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach ($paises as $pais)
        <tr>
            <td>{{$pais->id}}</td>
            <td>{{$pais->nombre_pais}}</td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="modalpais" title="Agregar nuevo país" icon="fas fa-plus" size="lg">
    <form action="{{route('pais.store')}}" method="post">
        @csrf
        <div class="row">
            <x-adminlte-input name="nombre_pais" label="Nombre del pais" placeholder="Colombia"/>
        </div>
        <x-adminlte-button type="submit" label="Guardar pais" theme="primary" icon="fas fa-key"/>
    </form>
</x-adminlte-modal>
@endsection
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@endsection
@section('js')

@endsection