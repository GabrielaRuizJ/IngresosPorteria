@extends('adminlte::page')

@section('title', 'Socios')

@section('content_header')
    <h1><li class="fas fa-users"></li> Socios del sistema</h1>
@stop

@section('content')
@php
    $heads = ['ID','cedula','nombre','accion','email','secuencia','estado'];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
    @foreach ($socios as $datsocios)
        <tr>
            <td>{{$datsocios->id}}</td>
            <td>{{$datsocios->cedula}}</td>
            <td>{{$datsocios->nombre}}</td>
            <td>{{$datsocios->accion}}</td>
            <td>{{$datsocios->email}}</td>
            <td>{{$datsocios->secuencia}}</td>
            <td>
                @if ($datsocios->estado == 1)
                    <b>Activo</b>
                @else
                    <b>Inactivo</b>
                @endif
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>

@stop

@section('js')
    <script src="{{asset('/js/sincronizarSocios.js') }}"></script>
    @if(session()->has('mensaje'))
    <script>
        const contenidoHTMLRes = decodeEntities("{{session('mensaje')}}")
        Swal.fire({
            title:'Resultlado de sincronizacion',
            icon:'info',
            html:contenidoHTMLRes
        });
    </script>
    @endif
@stop