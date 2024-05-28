@extends('adminlte::page')
@section('title','Tipos de ingresos')
@section('content_header')
@can('tipoingreso.create')
    <x-adminlte-button label="Nueva tipo de ingreso" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalciudad" class="float-right" />
@endcan
    <h1><li class="fas fa-door-open"></li> Administración de tipos de ingreso</h1>
@endsection
@section('content')
@can('tipo_ingreso')
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Nuevo tipo de ingreso" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalpais" class="float-right" /></div>
@endcan
    @php
        $heads = [
            'ID','nombre del tipo de ingreso','' ];
    @endphp

<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
    @foreach ($tipoingresos as $tipoingreso)
    <tr>
        <td>{{$tipoingreso->id}}</td>
        <td>{{$tipoingreso->nombre_ingreso}}</td>
        <td>
            @can('tipo_ingreso.edit')
            @endcan
        </td>
    </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="modalpais" title="Agregar un nuevo tipo de ingreso" icon="fas fa-door-open" size="lg">
    <form action="{{route('tipo_ingreso.create')}}" method="post">
        @csrf
        <div class="row-md-12">
            <x-adminlte-input required name="nombre_ingreso" label="Nombre del tipo de ingreso"/>
        </div>
        @can('tipo_ingreso.create')
            <x-adminlte-button type="submit" label="Guardar tipo de ingreso" theme="primary" icon="fas fa-door-open"/>
        @endcan
    </form>
</x-adminlte-modal>
@endsection


@section('js')
    @if(session()->has('mensaje'))
    <script>
        Swal.fire({
            title:'Correcto',
            icon:'success',
            text:"{{session('mensaje')}}"
        });
    </script>
    @endif
@stop