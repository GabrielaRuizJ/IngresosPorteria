@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><li class="fas fa-user-lock"></li> Bloqueos de socios del sistema</h1>
@stop

@section('content')
@php
    $heads = ['ID','cedula','accion','bloqueo','fecha inicio','fecha fin',
        'indefinido','bloqueo consumo','bloqueo ingreso' ];
@endphp

@can('bloqueo.create')
    <div class="row float-right" style="margin-bottom: 10px">
        <x-adminlte-button label="Nuevo bloqueo x socio" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal" class="float-right"/>
    </div>
@endcan
{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach ($bloqueo_socio as $datbloqueo_socio)
        <tr>
            <td>{{$datbloqueo_socio->id}}</td>
            <td>{{$datbloqueo_socio->cedula}}</td>
            <td>{{$datbloqueo_socio->accion}}</td>
            <td>{{$datbloqueo_socio->tipo_bloqueo}}</td>
            <td>@if ($datbloqueo_socio->fecha_inicio_bloqueo ) {{$datbloqueo_socio->fecha_inicio_bloqueo}} @else N/A @endif </td>
            <td>@if ($datbloqueo_socio->fecha_fin_bloqueo ) {{$datbloqueo_socio->fecha_fin_bloqueo}} @else N/A @endif </td>
            <td>@if ($datbloqueo_socio->indefinido ) Si @else  No @endif </td>
            <td>@if ($datbloqueo_socio->bloqueo_consumo ) Si @else  No @endif </td>
            <td>@if ($datbloqueo_socio->bloqueo_ingreso ) Si @else  No @endif </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="myModal" title="Nuevo registro de bloqueo x socio" theme="primary"
        icon="fas fa-user-lock" size='lg' disable-animations>
        <form action="{{route('bloqueo.create')}}" method="POST">
            @csrf
                <div class="row">
                    <x-adminlte-input name="nombrebloqueo" required label="Nombre del bloqueo" fgroup-class="col-md-6" disable-feedback/>
                </div>
            @can('bloqueo.create')
                <x-adminlte-button type="submit" label="Guardar bloqueo" theme="primary" icon="fas fa-save"/>
            @endcan
        </form>
    </x-adminlte-modal>
@stop

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
    @if(session()->has('errormensaje'))
    <script>
        Swal.fire({
            title:'Error',
            icon:'error',
            text:"{{session('errormensaje')}}"
        });
    </script>
    @endif
@stop