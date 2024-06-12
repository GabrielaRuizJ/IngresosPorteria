@extends('adminlte::page')

@section('title', 'Bloqueo de ingresos')

@section('content_header')
    <h1><li class="fas fa-user-lock"></li> Bloqueos de personas en el sistema</h1>
@stop

@section('content')
@php
    $heads = ['ID','cedula','bloqueo','fecha inicio','fecha fin',
        'indefinido','bloqueo consumo','bloqueo ingreso','estado',''];
    $contador = 0;
@endphp

@can('bloqueo_ingreso.create')
    <div class="row float-right" style="margin-bottom: 10px">
        <x-adminlte-button label="Nuevo bloqueo de ingreso" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal" class="float-right"/>
    </div>
@endcan
{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
    @foreach ($bloqueo_ingreso as $datbloqueo_ingreso)
        <tr>
            <td>{{$datbloqueo_ingreso->id}}</td>
            <td>{{$datbloqueo_ingreso->cedula}}</td>
            <td>{{$datbloqueo_ingreso->tipo_bloqueo}}</td>
            <td>@if ($datbloqueo_ingreso->fecha_inicio_bloqueo ) {{$datbloqueo_ingreso->fecha_inicio_bloqueo}} @else N/A @endif </td>
            <td>@if ($datbloqueo_ingreso->fecha_fin_bloqueo ) {{$datbloqueo_ingreso->fecha_fin_bloqueo}} @else N/A @endif </td>
            <td>@if ($datbloqueo_ingreso->indefinido ) Si @else  No @endif </td>
            <td>@if ($datbloqueo_ingreso->bloqueo_consumo ) Si @else  No @endif </td>
            <td>@if ($datbloqueo_ingreso->bloqueo_ingreso ) Si @else  No @endif </td>
            <td>@if ($datbloqueo_ingreso->estado ) <b>Activo</b> @else  <b>Inactivo</b> @endif </td>
            <td>
                @if ($datbloqueo_ingreso->estado ) 
                    @can('bloqueo_ingreso.delete')
                        <form method="POST" action="{{route('bloqueo_ingreso.delete')}}" id="formElimBloq{{$contador}}" name="formElimAut{{$contador}}" >
                            @csrf
                            @method('delete')
                            <input type="hidden" name="datIdBloq" id="datIdBloq" value="{{$datbloqueo_ingreso->id}}">
                        </form>
                        <button onclick="elimBloqueo({{$contador}})" type="button" id="btnElimBloq{{$contador}}" name="btnElimBloq{{$contador}}" class="btn text-dark bg-light border border-danger"><i class="fas fa-times"></i> </button>
                    @endcan
                @endif 
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="myModal" title="Nuevo registro de bloqueo de personas" theme="primary"
        icon="fas fa-user-lock" size='lg' disable-animations>
        <form action="{{route('bloqueo_ingreso.create')}}" id="formBloqueoxPersona" method="POST">
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
                <div class="col" id="bloqueoCedulaDiv" >
                    <label for="cedulaBloqueo">Número de cedula</label>
                    <input type="text" id="cedulaBloqueo" name="cedulaBloqueo" class="form-control">
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
            <div  id="fecBloqueoIndf">
                <div class="row">
                    <div class="col">
                        <label for="fecInicioBloqueo">Fecha de inicio del bloqueo</label>
                        <input class="form-control" type="date" value="{{date('Y-m-d')}}" name="fecInicioBloqueo" id="fecInicioBloqueo">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="fecFinBloqueo">Fecha final del bloqueo</label>
                        <input class="form-control" type="date" value="{{date('Y-m-d')}}" name="fecFinBloqueo" id="fecFinBloqueo">
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <div class="col-md-12">
            @can('bloqueo_ingreso.create')
                <x-adminlte-button style="width:100%" id="btnBloqueoxSocio" type="submit" label="Guardar bloqueo" theme="primary" icon="fas fa-save"/>
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