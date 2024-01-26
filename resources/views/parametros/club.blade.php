@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1>Administración de clubes</h1>
@endsection
@section('content')
    @php
        $heads = [
            'ID','nombre','direccion','telefono','email principal','email secundario','ciudad', ];
    @endphp
    <x-adminlte-button label="Nuevo club" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalClub" class="float-right" />
    <x-adminlte-datatable id="tableclub" :heads="$heads">
        @foreach ($clubes as $club)
            <tr>{{$club->id}}</tr>
            <tr>{{$club->nombre_club}}</tr>
            <tr>{{$club->direccion}}</tr>
            <tr>{{$club->telefono}}</tr>
            <tr>{{$club->email1}}</tr>
            <tr>{{$club->email2}}</tr>
            <tr>{{$club->ciudad}}</tr>
        @endforeach
    </x-adminlte-datatable>
    <x-adminlte-modal id="modalClub" title="Agregar nuevo club" icon="fas fa-plus" size="lg">
        <form action="" method="post">
            @csrf
            <div class="row">
                <x-adminlte-input name="nameclub" label="Nombre del club" placeholder=""/>
                <x-adminlte-input name="direccion" label="Direccion" placeholder=""/>
            </div>
            <div class="row">
                <x-adminlte-input name="telefono" label="Telefono" placeholder=""/>
                <x-adminlte-input name="email1" label="Email principal" placeholder=""/>
            </div>
            <div class="row">
                <x-adminlte-input name="email secundario" label="Email secundario" placeholder=""/>
                <select name="" id="" disabled="disabled"></select>
            </div>
        </form>
    </x-adminlte-modal>
@endsection
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@endsection
@section('js')
    
@endsection