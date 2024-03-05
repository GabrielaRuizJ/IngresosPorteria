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
            <div class="row" id="ocupantes">

            </div>
            <x-adminlte-button label="Agregar ocupante" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal"/>
        </form>
    </div>

    <x-adminlte-modal id="myModal" title="Agregar datos del ocupante" theme="primary"
        icon="fas fa-user-lock" size='lg' disable-animations>
        <label>Tipo de ingreso:</label>    
        <div class="row">
                  
                @foreach ($ingresos as $ingreso)
                    <div class="col">
                            <input type="radio" name="tipoingreso" value="{{ $ingreso->id }}">
                        <label>{{ $ingreso->nombre_ingreso}}</label>&nbsp;&nbsp;&nbsp;
                    </div>
                @endforeach
            
        </div>
        <div class="row">
            <x-adminlte-input name="cedula" id="cedula" required label="Cedula del ocupante" fgroup-class="col-md-6"/>
            <x-adminlte-input name="nombre" id="nombre" required label="Nombre del ocupante" fgroup-class="col-md-6"/>
            <x-adminlte-button icon="fas fa-plus" theme="primary" onclick="h()" label="Agregar ocupante" />
        </div>

    </x-adminlte-modal>

@stop

@section('js')
    <script>
        function h(){
            alert("hola");
        }
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