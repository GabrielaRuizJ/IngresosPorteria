@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@can('permiso.create')
    <x-adminlte-button label="Nuevo permiso" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal" class="float-right"/>
@endcan
    <h1><li class="fas fa-user-lock"></li> Listado de permisos</h1>
@stop

@section('content')
@php
$heads = [
    'ID',
    'Nombre',
    '',
];

@endphp
<div class="container">
    @if ($errors->any())
        <div class="alert alert-warning" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        </div>
    @endif
</div>
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($permisos as $indice => $permiso)
            <tr>
                <td>{{$permiso->id}}</td>
                <td>{{$permiso->name}}</td>
                <td>
                    <a href="{{route('permiso.edit',['id'=>$permiso->id])}}" class="btn btn-xs btn-default text-primary mx-1 shadow">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    <x-adminlte-modal id="myModal" title="Nuevo registro de permisos" theme="primary"
        icon="fas fa-user-lock" size='lg' disable-animations>
        <form action="{{route('permiso.create')}}" method="POST">
            @csrf
                <div class="row">
                    <x-adminlte-input name="nombrepermiso" required label="Nombre del permiso" fgroup-class="col-md-6" disable-feedback/>
                </div>
            <x-adminlte-button type="submit" label="Guardar permiso" theme="primary" icon="fas fa-key"/>
        </form>
    </x-adminlte-modal>

@stop

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
@stop