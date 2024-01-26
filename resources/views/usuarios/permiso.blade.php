@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
@php
$heads = [
    'ID',
    'Nombre',
];

@endphp

{{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-button label="Nuevo rol" theme="primary" icon="fas fa-key" data-toggle="modal" data-target="#myModal" class="float-right"/>
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($datos as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

<x-adminlte-modal id="myModal" title="Nuevo registro de permisos" theme="primary"
    icon="fas fa-bolt" size='lg' disable-animations>
    <form action="{{route('permiso.create')}}" method="POST">
        @csrf
        <div class="row">
            <x-adminlte-input name="nombrepermiso" label="Nombre del rol" placeholder="Especificar el permiso"
                fgroup-class="col-md-6" disable-feedback/>
        </div>
        <x-adminlte-button type="submit" label="Guardar permiso" theme="primary" icon="fas fa-key"/>
    </form>
</x-adminlte-modal>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
@stop