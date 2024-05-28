@extends('adminlte::page')

@section('title', 'Bloqueo por socio')

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
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
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
<x-adminlte-modal id="myModal" title="Nuevo registro de bloqueo por socio" theme="primary"
        icon="fas fa-user-lock" size='lg' disable-animations>
        <form action="{{route('bloqueo_socio.create')}}" id="formBloqueoxSocio" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="listado_bloqueos">Tipo de bloqueo</label>
                    <select name="listado_bloqueos" id="listado_bloqueos" class="form-control">
                        <option value="">Lista de bloqueos</option>
                        @foreach ($bloqueos as $datbloqueoadd)
                            <option value="{{$datbloqueoadd->id}}">{{$datbloqueoadd->nombre_bloqueo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="accionBloqueo">Número de accion</label>
                    <input type="text" id="accionBloqueo" name="accionBloqueo" class="form-control">
                </div>
                <div class="col" id="bloqueoCedulaDiv" >
                    <label for="cedulaBloqueo">Número de cedula</label>
                    <input type="text" id="cedulaBloqueo" name="cedulaBloqueo" class="form-control">
                </div>
                <div class="col">
                    <label for="bloqueoTodosAccion">Bloquear todo el nucleo</label>
                    <input type="checkbox" id="bloqueoTodosAccion" name="bloqueoTodosAccion" class="form-control">
                </div>
                
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label for="bloqueo_ingreso">Bloquear ingreso al club</label>
                    <input class="form-control" type="checkbox" name="bloqueo_ingreso" id="bloqueo_ingreso">
                </div>
                <div class="col">
                    <label for="bloqueo_consumo">Bloquear consumos</label>
                    <input class="form-control" type="checkbox" name="bloqueo_consumo" id="bloqueo_consumo">
                </div>
                <div class="col">
                    <label for="bloqueo_indf">Bloqueo indefinido</label>
                    <input class="form-control" type="checkbox" name="bloqueo_indf" id="bloqueo_indf">
                </div>
            </div>
            <br>
            <div class="row" id="fecBloqueoIndf" style="display:none">
                <div class="col">
                    <label for="bloqueo_ingreso">Fecha de inicio del bloqueo</label>
                    <input  disabled class="form-control" type="date" value="{{date('Y-m-d')}}" name="fecInicioBloqueo" id="fecInicioBloqueo">
                </div>
                <div class="col">
                    <label for="bloqueo_indf">Fecha final del bloqueo</label>
                    <input disabled  class="form-control" type="date" value="{{date('Y-m-d')}}" name="fecFinBloqueo" id="fecFinBloqueo">
                </div>
            </div>
        </form>
        <hr>
        <div class="col-md-12">
            @can('bloqueo.create')
                <x-adminlte-button style="width:100%" id="btnBloqueoxSocio" type="submit" label="Guardar bloqueo socio" theme="primary" icon="fas fa-save"/>
            @endcan
        </div>
    </x-adminlte-modal>
@stop

@section('js')
    <script src="{{asset('/js/bloqueoSocio.js') }}"></script>
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