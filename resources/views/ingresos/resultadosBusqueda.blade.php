@extends('adminlte::page')
@section('title','Busqueda de ingresos')
@section('content_header')
    <h1><li class="fas fa-door-open"></li>Resultado de la búsqueda</li> </h1>
@endsection
@section('content')
    <br>
    @php print "<h4> Detalle de la búsqueda: </h4>"; @endphp
    <br>
    @php print "<label> Rango de fechas:</label>&nbsp;<i>".$fecha_inicio."</i>&nbsp;<label>a</label>&nbsp;<i>".$fecha_fin." </i>"; @endphp
    <br>
    @if ($restipobusqueda == 1)
        <label>Tipo de ingresos:</label><br>
        @foreach ($busquedaIngresos as $datBusquedaIngresos)
            <label>* {{$datBusquedaIngresos->nombre_ingreso}}</label>
        @endforeach
    @elseif($restipobusqueda == 2)
        <label>Tipos de vehiculos</label><br>
        @foreach ($busquedaVehiculos as $datBusquedaVehiculos)
            <label>* {{$datBusquedaVehiculos->nombre_vehiculo}}</label>
        @endforeach
    @elseif($restipobusqueda == 3)

        <label>Tipo de ingresos:</label><br>
        @foreach ($busquedaIngresos as $datBusquedaIngresos)
            <label>* {{$datBusquedaIngresos->nombre_ingreso}}</label>
        @endforeach
        <br>
        <label>Tipos de vehiculos</label><br>
        @foreach ($busquedaVehiculos as $datBusquedaVehiculos)
            <label>* {{$datBusquedaVehiculos->nombre_vehiculo}}</label>
        @endforeach

    @elseif($restipobusqueda == 4)
        <label>* Todos los tipos de ingresos</label><br>
        <label>* Todos los tipos de vehiculos</label><br>
    @endif

    @php
        $heads = [
            'ID','tipo de ingreso','cedula','nombre','fecha de ingreso','hora de ingreso','vehiculo','placa' ];
    @endphp

<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
    @foreach ($busqueda as $datBusqueda)
    <tr>
        <td>{{ $datBusqueda->id }}</td>
        <td>{{ $datBusqueda->nombre_ingreso }}</td>
        <td>{{ $datBusqueda->cedula }}</td>
        <td>{{ $datBusqueda->nombre }}</td>
        <td>{{ $datBusqueda->fecha }}</td>
        <td>{{ $datBusqueda->hora_ingreso }}</td>
        <td>{{ $datBusqueda->nombre_vehiculo }}</td>
        <td>{{ $datBusqueda->placa }}</td>
    </tr>
    @endforeach
</x-adminlte-datatable>

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
            title:'Correcto',
            icon:'success',
            text:"{{session('mensaje')}}"
        });
    </script>
    @endif
@stop