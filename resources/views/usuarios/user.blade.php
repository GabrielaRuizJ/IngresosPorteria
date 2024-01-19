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
<x-adminlte-datatable id="table1" :heads="$heads">
        <tr>
            @foreach($datos as $dato)
            <td>{{ $dato->id }}</td>
            <td>{{ $dato->name }}</td>
            <td>{{ $dato->username }}</td>
            <td>{{ $dato->cedula }}</td>
            <td>{{ $dato->email }}</td>

        @endforeach
        </tr>
</x-adminlte-datatable>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
@stop