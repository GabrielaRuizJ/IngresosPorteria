@extends('adminlte::page')

@section('title','Ingresos')

@section('content_header')
    <h1><li class="fas fa-door-open"></li>Realizar ingresos</h1>
@stop

@section('content')
        <form action="{{route('ingreso.create')}}" method="post">
            @csrf            
            <div class="row">
                    <label>Tipo de vehiculo</label>
            </div>
            <div class="row">
                <div class="col">
                    @foreach ($vehiculos as $vehiculo)
                        <input id="tipov{{$vehiculo->id}}" type="radio" name="tipov" value="{{ $vehiculo->id }}">
                        <label  for="tipov{{$vehiculo->id}}">{{ $vehiculo->nombre_vehiculo}}</label>&nbsp;&nbsp;&nbsp;
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <!-- Confirm Password -->
                        <x-input-label for="placa_v" :value="__('Placa del vehiculo')" />
                        <x-adminlte-input id="placa_v" 
                                        type="text"
                                        name="placa"
                                        id="placa"
                                        fgroup-class="col-md-12" required >
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-car"></i>
                                            </div>
                                        </x-slot>
                        </x-adminlte-input>
                        <x-input-error :messages="$errors->get('placa_v')" class="mt-2" />
                </div>
            </div>
            <div id="ocupantes">

            </div>
            <div class="row">
                <div class="col">
                    @can('ingreso.create')
                        <x-adminlte-button style="width: 100%;height:5em" data-toggle="modal" data-target="#modalIngreso" icon="fas fa-plus" theme="primary" label="Agregar ocupante" />
                    @endcan
                </div>
                <div class="col">
                    @can('ingreso.create')
                        <x-adminlte-button style="width: 100%;height:5em" data-toggle="modal" icon="fas fa-save" theme="success" label="Registrar ingreso" />
                    @endcan
                </div>
            </div>
        </form>

    <x-adminlte-modal class="modal-lg" id="modalIngreso" title="Agregar acompañante" icon="fas fa-user-plus">
        <form action="" id="formIng" method="post">
            @csrf
            @foreach ($ingresos as $ingreso)
                <input required type="radio" id="tipoi{{ $ingreso->id }}" name="tipoi" value="{{ $ingreso->id }}">
                <label for="tipoi{{ $ingreso->id }}">{{ $ingreso->nombre_ingreso}}</label>&nbsp;&nbsp;&nbsp;
            @endforeach
            <div class="row" >
                <hr>
                <x-adminlte-input name="cedula" id="cedulaOcp" required label="Cedula del ocupante" fgroup-class="col-md-6"/>
                <x-adminlte-input name="nombre" id="nombreOcp" required label="Nombre del ocupante" fgroup-class="col-md-6"/>
                <hr>
            </div>
        </form>
        <div class="col">
            <span id="textcarg"></span>
        </div>
        <div class="col">
            @can('ingreso.create')
                <x-adminlte-button style="width: 100%;height:5em" id="btn-consulta"  type="submit" label="Validar datos" theme="primary" icon="fas fa-save" />
            @endcan
        </div>
    </x-adminlte-modal>

@stop

@section('js')
    <script src="{{asset('/js/validacionIngreso.js') }}"></script>
@stop