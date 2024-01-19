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
    'Usuario',
    'Cedula',
    'Email',
];

@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-button label="Nuevo rol" theme="primary" icon="fas fa-key" data-toggle="modal" data-target="#myModal" class="float-right"/>
<x-adminlte-datatable id="table1" :heads="$heads">
        <tr>
           
        </tr>
</x-adminlte-datatable>

<x-adminlte-modal id="myModal" title="Nuevo registro de roles" theme="primary"
    icon="fas fa-bolt" size='lg' disable-animations>
    <form action="{{route('role.create')}}" method="POST">
        @csrf
        <div class="row">
            <x-adminlte-input name="nombrerol" label="Label" placeholder="placeholder"
                fgroup-class="col-md-6" disable-feedback/>
        </div>
        <x-adminlte-button type="submit" label="Success" theme="success" icon="fas fa-thumbs-up"/>
    </form>
</x-adminlte-modal>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
@stop