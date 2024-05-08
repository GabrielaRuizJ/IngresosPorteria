@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1><li class="fas fa-door-open"></li>Personas dentro del club</li> </h1>
    <h3>Fecha: {{date('Y-m-d')}}</h3>
@endsection
@section('content')
    @php
        $heads = [
            'ID','tipo de ingreso','cedula','nombre','vehiculo','placa','hora de ingreso','' ];
    @endphp
@can('salida.create')
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Salida masiva del día" theme="primary" icon="fas fa-door-closed" data-toggle="modal" data-target="#modalSalidasMasivas" class="float-right" />
</div>
@endcan
<x-adminlte-datatable id="table1" :heads="$heads">
   @foreach($veringresosHoy as $dato)
        <tr>
            <td>{{ $dato->id }}</td>
            <td>{{ $dato->nombre_ingreso }}</td>
            <td>{{ $dato->cedula }}</td>
            <td>{{ $dato->nombre }}</td>
            <td>{{ $dato->nombre_vehiculo }}</td>
            <td>{{ $dato->placa }}</td>
            <td>{{ $dato->hora_ingreso }}</td>
            <td>
                @can('salida.create')
                <a data-toggle="modal" data-target="#modalSalidaIndv" onclick="salidaIndv('{{$dato->id}}','{{$dato->nombre_ingreso}}','{{$dato->cedula}}','{{$dato->nombre}}','{{$dato->nombre_vehiculo}}','{{$dato->placa}}')" href="#" class="btn btn-lg btn-default text-danger mx-1 shadow">
                    <i class="fa fa-lg fa-fw fas fa-door-closed"></i>
                </a>
                @endcan
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>

<x-adminlte-modal id="modalSalidasMasivas" title="Realizar salidas masivas" icon="fas fa-door-closed" size="lg">
    <form method="POST" id="formSMV" action="{{ route('salidamasiva') }}">
        @csrf
            <hr>
            <div class="row">
                <div class="col"><label for="tiposalidaTodos">Todas las personas dentro del club</label></div>
                <div class="col"><input type="checkbox" class="form-control"  name="tiposalidaTodos" id="tiposalidaTodos" value="1"></div>
            </div>
            <hr>
        @foreach($ingresos as $indice => $dato1)
            <div class="row">
                <div class="col">
                    <label>{{$dato1->nombre_ingreso}}(s) dentro del club</label>
                </div>
                <div class="col">
                    <input type="checkbox" value="{{$dato1->id}}" name="tiposalida[]" id="tiposalida" class="form-control tiposalidaClass" >
                </div>    
            </div>
            <hr>
        @endforeach
    </form>
    <div class="row-md-12">
        @can('salida.create')
            <x-adminlte-button type="button" id="salidaMSV" label="Confirmar salida masiva" theme="primary" icon="fas fa-user-plus"/>
        @endcan
    </div>
</x-adminlte-modal>

<x-adminlte-modal id="modalSalidaIndv" title="Realizar salida individual" icon="fas fa-door-closed" size="lg">
    <form method="POST" id="formSIDV" action="{{ route('salida.create') }}">
        @csrf
            <hr>
            <h4>Detalles salida</h4>
            <div class="row">
                <input class="form-control" id="dat1salidaINDV" name="dat1salidaINDV" type="hidden">
                <div class="col">
                    <label for="dat2salidaINDV">Tipo de ingreso</label>
                    <input class="form-control" id="dat2salidaINDV" name="dat2salidaINDV" type="text" disabled>
                </div>
                <div class="col">
                    <label for="dat3salidaINDV">Documento</label>
                    <input class="form-control" id="dat3salidaINDV" name="dat3salidaINDV" type="text" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="dat4salidaINDV">Nombre</label>
                    <input class="form-control" id="dat4salidaINDV" name="dat4salidaINDV" type="text" disabled>
                </div>
                <div class="col">
                    <label for="dat5salidaINDV">Tipo de vehiculo</label>
                    <input class="form-control" id="dat5salidaINDV" name="dat5salidaINDV" type="text" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="dat6salidaINDV">Placa</label>
                    <input class="form-control" id="dat6salidaINDV" name="dat6salidaINDV" type="text" disabled>
                </div>
            </div>
            <hr>
    </form>

        @can('salida.create')
            <x-adminlte-button type="button" id="btnsalidaIndv" label="Confirmar salida" theme="primary" icon="fas fa-user-plus"/>
        @endcan
</x-adminlte-modal>

@endsection


@section('js')
    <script src="{{asset('/js/salidasValidacion.js') }}"></script>
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