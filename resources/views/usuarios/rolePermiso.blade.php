@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles y permisos</h1>
@stop

@section('content')
 <div class="card">
    <div class="header">
        <p>{{$rol->name}}</p>
    </div>
 </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
@stop