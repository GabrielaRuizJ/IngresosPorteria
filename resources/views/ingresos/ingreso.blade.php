@extends('adminlte::page')

@section('title','Ingresos')

@section('content_header')
    <h1><li class="fas fa-door-open"></li>Realizar ingresos</h1>
@stop

@section('content')
        <form id="formIng"  method="post">
            @csrf            
            <hr>
            <div class="row">
                    <label>Tipo de vehiculo</label>
            </div>
            <div class="row" >
                <x-adminlte-input name="iduserlog" id="iduserlog"  value="{{ $userId }}"  hidden fgroup-class="col-md-6"/>
            </div>
            <div class="row">
                <div class="col">
                    @foreach ($vehiculos as $vehiculo)
                        <input style="width: 3em;height: 3em;vertical-align: middle;" id="tipov{{$vehiculo->id}}" type="radio" name="tipov" value="{{ $vehiculo->id }}">
                        <label style="vertical-align: middle;font-size: 1.2rem;" for="tipov{{$vehiculo->id}}">{{ $vehiculo->nombre_vehiculo}}</label>&nbsp;&nbsp;&nbsp;
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-11">
                    <!-- Confirm Password -->
                        <x-input-label for="placa_v" :value="__('Placa del vehiculo')" />
                        <x-adminlte-input type="text"
                                        name="placa"
                                        id="placa_v"
                                        fgroup-class="col-md-12" required >
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-car"></i>
                                            </div>
                                        </x-slot>
                        </x-adminlte-input>
                        <x-input-error :messages="$errors->get('placa_v')" class="mt-2" />
                </div>
                <div class="col" style="align-self: center;">
                    <x-adminlte-button onclick="fBorrarCampo()" style="width: 100%;height:3rem;" id="borrarCampo" icon="fas fa-times" theme="danger" />
                </div>
            </div>
            <hr>
            <div id="dat_canje">
            </div>
            <hr>
            <div class="row">
                <label>Tipo de ingreso</label>
            </div>
            <div class="row" >
                <div class="col">
                    @foreach ($ingresos as $ingreso)
                        <input style="width: 3em;height: 3em;vertical-align: middle;" required type="radio" id="tipoi{{ $ingreso->id }}" name="tipoi" value="{{ $ingreso->id }}">
                        <label style="vertical-align: middle;font-size: 1.2rem;" for="tipoi{{ $ingreso->id }}">{{ $ingreso->nombre_ingreso}}</label>&nbsp;&nbsp;&nbsp;
                    @endforeach
                </div>
                <hr>
            </div>
            <hr>
            <div class="row" >
                <hr>
                <x-adminlte-input name="cedula" id="cedulaOcp" required label="Cedula del ocupante" fgroup-class="col-md-4"/>
                <x-adminlte-input name="primAp" id="primAp" required label="Primer Apellido" fgroup-class="col-md-4"/>
                <x-adminlte-input name="segAp" id="segAp" required label="Segundo Apellido" fgroup-class="col-md-4"/>
                <hr>
            </div>
            <div class="row" >
                <hr>
                <x-adminlte-input name="primNm" id="primNm" required label="Primer Nombre" fgroup-class="col-md-6"/>
                <x-adminlte-input name="segNm" id="segNm" required label="Segundo Nombre" fgroup-class="col-md-6"/>
                <hr>
            </div>
            <div class="row" >
                <x-adminlte-input name="dtOct1" id="dtOct1"   hidden fgroup-class="col-md-6"/>
                <x-adminlte-input name="dtOct2" id="dtOct2"   hidden fgroup-class="col-md-6"/>
            </div>
        </form>
        <div class="row">
            <div class="col">
                @can('ingreso.create')
                    <x-adminlte-button style="width: 100%;height:5em" id="guardarIngreso" icon="fas fa-save" theme="success" label="Registrar ingreso" />
                @endcan
            </div>
        </div>
        <br><br>
        {{-- Custom --}}

    <x-adminlte-modal id="modalCanje" title="Detalles del canje" size="lg" theme="teal"
    icon="fas fa-bell" v-centered static-backdrop scrollable>
    <div id="detalles-canje" >
        <div class="row">
            <div class="col">
                <label for="rango1canje">Fecha inicio canje</label>
                <input class="form-control" type="date" value="{{ now()->format('Y-m-d') }}" id="rango1canje" name="rango1canje">
            </div>
            <div class="col">
                <label for="rango2canje">Fecha fin canje</label>
                <input class="form-control" type="date" value="{{ now()->format('Y-m-d') }}" id="rango2canje" name="rango2canje">
            </div>
        </div>
        <hr>
        <table id="tablaclubes" class="table table-striped" border="1">
            <thead>
                <tr><th>Id</th><th>Club</th><th></th></tr>
            </thead>
            <tbody id="bodytablecanje">
            </tbody>
        </table>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button style="width:45%;height:5em" class="mr-auto" theme="success" onclick="agregarClub()" label="Agregar canje"/>
        <x-adminlte-button style="width:45%;height:5em" theme="danger" label="Cancelar" data-dismiss="modal"/>
    </x-slot>
    </x-adminlte-modal>

@stop
@section('js')
    <script src="{{asset('/js/validacionIngreso.js') }}"></script>
    @if(session()->has('mensaje'))
    <script>
        Swal.fire({
            title:'Correcto',
            icon:'success',
            text:"{{session('mensaje')}}"
        });
    </script>
@endif
@stop