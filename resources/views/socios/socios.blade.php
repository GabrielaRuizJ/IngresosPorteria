@extends('adminlte::page')

@section('title', 'Socios')

@section('content_header')
    <h1><li class="fas fa-users"></li> Socios del sistema</h1>
@stop

@section('content')
@php
    $heads = ['ID','cedula','nombre','accion','email','secuencia'];
@endphp

@can('socio.create')
    <div class="row float-right" style="margin-bottom: 10px">
        <form action="{{route('socio.create')}}" id="syncSocios" method="post">
            @csrf
            <x-adminlte-button type="button" id="btnSyncSocios" label="Sincronizar datos" theme="primary" icon="fas fa-sync" class="float-right" />
        </form>
    </div>
@endcan
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