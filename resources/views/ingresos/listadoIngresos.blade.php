@extends('adminlte::page')
@section('title','Filtro de ingresos')
@section('content_header')
    <h1><li class="fas fa-search"></li> Búsqueda de ingresos</li> </h1>
@endsection
@section('content')
    <form method="POST" id="formBusquedaIngresos" action="{{route('resBusquedaIngresos')}}">
        @csrf
        <br>
        <h4>Rango de fechas</h4>
            <div class="row">
                <div class="col">
                    <label for="fechainiciobusqueda">Fecha inicio de búsqueda</label>
                    <input class="form-control" type="date" value="{{date('Y-m-d')}}" name="fechainiciobusqueda" id="fechainiciobusqueda">
                </div>
                <div class="col">
                    <label for="fechafinbusqueda">Fecha fin de búsqueda</label>
                    <input class="form-control" type="date" value="{{date('Y-m-d')}}" name="fechafinbusqueda" id="fechafinbusqueda">
                </div>
            </div>
            <br>
            <h4>Tipos de ingreso</h4>
            <hr>
            <div class="row">
                <div class="col"><label for="tiposalidaTodos">Todos los tipos de ingreso</label></div>
                <div class="col"><input type="checkbox" class="form-control" name="tiposalidaTodos" id="tiposalidaTodos" value="1"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
            <hr>
            @php
                $indice = 1; // Inicializar un contador personalizado en 1
            @endphp
            @foreach($tipo_ingresos as  $dat_ingreso)
                @if ($indice % 2 == 0)
                        <div class="col">
                            <label for="tiposalida{{$indice}}">{{$dat_ingreso->nombre_ingreso}}</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" class="form-control"  value="{{$dat_ingreso->id}}" name="tiposalida" id="tiposalida{{$indice}}">
                        </div> 
                    </div> 
                    <hr>
                @else
                    <div class="row">
                        <div class="col">
                            <label for="tiposalida{{$indice}}">{{$dat_ingreso->nombre_ingreso}}</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" class="form-control" value="{{$dat_ingreso->id}}" name="tiposalida" id="tiposalida{{$indice}}">
                        </div> 
                    
                @endif
                @php
                    $indice++;
                @endphp
            @endforeach
            <br>
            <h4>Tipos de vehiculos</h4>
            <hr>
            @php
                $indice2 = 1; // Inicializar un contador personalizado en 1
            @endphp
            @foreach($tipo_vehiculos as  $dat_vehiculo)
                @if ($indice2 % 2 == 0 )
                    <div class="row">
                        <div class="col">
                            <label for="tipovehiculo{{$indice2}}">{{$dat_vehiculo->nombre_vehiculo}}</label>
                        </div>
                        <div class="col">
                            <input type="checkbox" class="form-control"  value="{{$dat_vehiculo->id}}" name="tipovehiculo" id="tipovehiculo{{$indice2}}">
                        </div> 
                    <hr>
                @else
                    
                        @if ($indice2 == 1)
                        <div class="row">
                            <div class="col"><label for="tiposvehiculosTodos">Todos los tipos de vehiculos</label></div>
                            <div class="col"><input type="checkbox" class="form-control"  name="tiposvehiculosTodos" id="tiposvehiculosTodos" value="1"></div>  
                            
                            <div class="col">
                                <label for="tipovehiculo{{$indice2}}">{{$dat_vehiculo->nombre_vehiculo}}</label>
                            </div>
                            <div class="col">
                                <input type="checkbox" class="form-control"  value="{{$dat_vehiculo->id}}" name="tipovehiculo" id="tipovehiculo{{$indice2}}">
                            </div> 
                        </div>
                        <hr>
                        @else
                                <div class="col">
                                    <label for="tipovehiculo{{$indice2}}">{{$dat_vehiculo->nombre_vehiculo}}</label>
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="form-control" value="{{$dat_vehiculo->id}}" name="tipovehiculo" id="tipovehiculo{{$indice2}}">
                                </div> 
                            </div> 
                            <hr>
                        @endif
                @endif
                @php
                    $indice2++;
                @endphp
            @endforeach
            <div class="row-md-12">
                @can('salida.create')
                    <x-adminlte-button type="submit" style="width:100%;padding: 15px 0px;" label="Realizar búsqueda" theme="primary" icon="fas fa-search"/>
                @endcan
            </div>
    </form>
@endsection


@section('js')
    <script src="{{asset('/js/busquedaIngresos.js') }}"></script>
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