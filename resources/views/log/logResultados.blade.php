@extends('adminlte::page')
@section('title','Registro de log')
@section('content_header')
    <h1><li class="fas fa-shoe-prints"></li>Reporte de movimientos del sistema</li> </h1>
@endsection
@php
    $heads = ['ID','fecha','accion','tabla','id del usuario','usuario','comentarios','fecha de creación del log' ];
@endphp

@section('content')
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
    @foreach ($logs as $logdat)
    <tr>
        <td>{{ $logdat->id }}</td>
        <td>{{ $logdat->fecha }}</td>
        <td>{{ $logdat->accion }}</td>
        <td>{{ $logdat->tabla_accion }}</td>
        <td>{{ $logdat->id_usuario }}</td>
        <td>{{ $logdat->nombre_usuario }}</td>
        <td>{{ $logdat->comentarios }}</td>
        <td>{{ $logdat->created_at }}</td>
    @endforeach
</x-adminlte-datatable>
@endsection
