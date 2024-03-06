@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
@can('tipoingreso.create')
    <x-adminlte-button label="Nueva tipo de vehiculo" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalciudad" class="float-right" />
@endcan
    <h1><li class="fas fa-car"></li> Administración de tipos de vehiculos</h1>
@endsection
@section('content')
@role('Admin')
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Nuevo tipo de vehiculo" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalpais" class="float-right" /></div>
@endrole
    @php
        $heads = [
            'ID','nombre del tipo de vehiculo','' ];
    @endphp

<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach ($tipovehiculos as $tipovehiculo)
    <tr>
        <td>{{$tipovehiculo->id}}</td>
        <td>{{$tipovehiculo->nombre_vehiculo}}</td>
        <td>
            @can('tipo_vehiculo.edit')
            @endcan
        </td>
    </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="modalpais" title="Agregar un nuevo tipo de vehiculo" icon="fas fa-car" size="lg">
    <form action="{{route('tipo_vehiculo.create')}}" method="post">
        @csrf
        <div class="row-md-12">
            <x-adminlte-input required name="nombre_vehiculo" label="Nombre del tipo de vehiculo"/>
        </div>
        <x-adminlte-button type="submit" label="Guardar tipo de vehiculo" theme="primary" icon="fas fa-car"/>
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