@extends('adminlte::page')

@section('title', 'Bloqueos')

@section('content_header')
    <h1><li class="fas fa-user-slash"></li>Bloqueos de socios del sistema</h1>
@stop

@section('content')
@php
    $heads = ['ID','bloqueo','estado',''];
    $contador = 0;
@endphp

@can('bloqueo.create')
    <div class="row float-right" style="margin-bottom: 10px">
        <x-adminlte-button label="Nuevo bloqueo" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal" class="float-right"/>
    </div>
@endcan
{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
    @foreach ($bloqueos as $datbloqueos)
        <tr>
            <td>{{$datbloqueos->id}}</td>
            <td>{{$datbloqueos->nombre_bloqueo}}</td>
            <td>@if ($datbloqueos->estado ) <b>Activo</b> @else  <b>Inactivo</b> @endif </td>
            <td>
                @can('bloqueo.delete')
                    <form method="POST" action="{{route('bloqueo.delete')}}" id="formElimBloq{{$contador}}" name="formElimAut{{$contador}}" >
                        @csrf
                        @method('delete')
                        <input type="hidden" name="datIdBloq" id="datIdBloq" value="{{$datbloqueos->id}}">
                    </form>
                    @if ($datbloqueos->estado ) 
                        <button onclick="elimBloqueo({{$contador}},'Desactivar')" type="button" id="btnElimBloq{{$contador}}" name="btnElimBloq{{$contador}}" class="btn text-dark bg-light border border-danger">
                            <i class="fas fa-toggle-off"></i>
                        </button>
                    @else  
                        <button onclick="elimBloqueo({{$contador}},'Activar')" type="button" id="btnElimBloq{{$contador}}" name="btnElimBloq{{$contador}}" class="btn text-dark bg-light border border-danger">
                            <i class="fas fa-toggle-on"></i>
                        </button>
                    @endif 
                @endcan
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="myModal" title="Nuevo registro de bloqueo" theme="primary"
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
    <script src="{{asset('/js/bloqueosSistema.js') }}"></script>
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