@extends('adminlte::page')
@section('css')
<link rel="stylesheet" href="css/admin_custom.css">
@endsection
@section('title', 'Sistema de ingresos')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Bienvenido al sistema de ingresos de Pueblo Viejo Country Club.</p>
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-title">
                        <h3>Ingresos</h3>
                    </div>
                    <div class="card-body">
                        @can('ingresos')
                            <a href="{{ route('ingresos') }}" class="btn btn-primary"><li class="fas fa-door-open"></li> Realizar ingresos</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-title">
                        <h3>Salidas</h3>
                    </div>
                    <div class="card-body">
                        @can('salidas')
                        <a href="{{ route('salidas') }}" class="btn btn-primary"><li class="fas fa-door-open"></li> Realizar salidas</a>
                        @endcan
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-title">
                        <h3>Consultas</h3>
                    </div>
                    <div class="card-body">
                        @can('log')
                        <a href="{{ route('log') }}" class="btn btn-primary"><li class="fas fa-search"></li> Consultar de logs del sistema</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-title">
                        <h3>Reportes</h3>
                    </div>
                    <div class="card-body">
                        @can('ingreso.find')
                        <a href="{{ route('listadoIngresos') }}" class="btn btn-primary"><li class="fas fa-print"></li> Descargar reportes</a>
                        @endcan
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
@stop

@section('js')
@stop