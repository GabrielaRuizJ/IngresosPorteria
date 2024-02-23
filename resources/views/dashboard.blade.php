@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Bienvenido al sistema de ingresos.</p>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-title">
                    <h3>Ingresos</h3>
                </div>
                <div class="card-body">
                    <p>Realizar ingresos al sistema</p>
                    <x-adminlte-button />
                </div>
            </div>
        </div>
        
    </div>
   
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@endsection
@section('js')
@stop