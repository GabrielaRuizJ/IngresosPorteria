@extends('adminlte::page')
@section('css')
<link rel="stylesheet" href="css/admin_custom.css">
@endsection
@section('title', 'Dashboard')

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
                        <a href="{{ route('ingresos') }}" class="btn btn-primary"><li class="fas fa-door-open"></li> Realizar ingresos</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-title">
                        <h3>Salidas</h3>
                    </div>
                    <div class="card-body">
                        <x-adminlte-button label="Realizar salidas" icon="fas fa-sign-out-alt" theme="primary" />
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
                        <x-adminlte-button label="Consultar datos del sistema" icon="fas fa-search" theme="primary" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-title">
                        <h3>Reportes</h3>
                    </div>
                    <div class="card-body">
                        <x-adminlte-button label="Descargar reportes" icon="fas fa-print" theme="primary" />
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
@stop

@section('js')
@stop