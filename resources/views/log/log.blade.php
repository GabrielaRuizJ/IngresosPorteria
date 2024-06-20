@extends('adminlte::page')
@section('title','Búsqueda de movimiento')
@section('content_header')
    <h1><li class="fas fa-shoe-prints"></li> Reporte de movimientos del sistema</li> </h1>
@endsection

@section('content')
<form method="POST" id="formBusquedaLog" action="{{route('log.find')}}">
    @csrf
    <br>
    <h4>Rango de fechas</h4>
        <div class="row">
            <div class="col">
                <label for="fechainiciobusqueda">Fecha inicio de búsqueda</label>
                <input class="form-control" type="date" value="{{date('Y-m-d')}}" required name="fechainiciobusqueda" id="fechainiciobusqueda">
            </div>
            <div class="col">
                <label for="fechafinbusqueda">Fecha fin de búsqueda</label>
                <input class="form-control" type="date" value="{{date('Y-m-d')}}" required name="fechafinbusqueda" id="fechafinbusqueda">
            </div>
        </div>
        <br>
        <div class="row-md-12">
            @can('log.find')
                <x-adminlte-button type="submit" style="width:100%;padding: 15px 0px;" label="Realizar búsqueda" theme="primary" icon="fas fa-search"/>
            @endcan
        </div>
</form>
@endsection
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
            title:'Correcto',
            icon:'success',
            text:"{{session('mensaje')}}"
        });
    </script>
    @endif
@stop