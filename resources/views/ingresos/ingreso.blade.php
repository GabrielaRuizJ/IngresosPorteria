@extends('adminlte::page')

@section('title','Ingresos')

@section('content_header')
    <h1><li class="fas fa-door-open"></li>Realizar ingresos</h1>
@stop

@section('content')

    <div class="container">
        <form action="" method="post">
            @csrf
            
            <div class="row">
                    <label>Tipo de vehiculo</label>
            </div>
            <div class="row">
                <div class="col">
                    @foreach ($vehiculos as $vehiculo)
                        <input type="radio" name="tipov" value="{{ $vehiculo->id }}">
                        <label>{{ $vehiculo->nombre_vehiculo}}</label>&nbsp;&nbsp;&nbsp;
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
            <div class="row" >
                <hr>
                <x-adminlte-input name="cedula" id="cedula" required label="Cedula del ocupante" fgroup-class="col-md-6"/>
                <x-adminlte-input name="nombre" id="nombre" required label="Nombre del ocupante" fgroup-class="col-md-6"/>
                <hr>
            </div>
            <x-adminlte-button icon="fas fa-plus" theme="primary" label="Agregar ocupante" />
        </form>
    </div>


@stop

@section('js')
    <script>
     /*   $.ajax({
                url: 'http://servicio-externo.com/ruta',
                type: 'POST',
                dataType: 'json',
                data: {
                    dato1: $('#dato1').val(),
                    dato2: $('#dato2').val()
                },
                success: function(response){
                    console.log(response);
                },
                error: function(xhr, status, error){
                    console.error(error);
                }
        });
        */
    </script>
@stop