@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><li class="fas fa-users"></li> Usuarios del sistema</h1>
@stop

@section('content')
@php
$heads = [
    'ID',
    'Nombre',
    'Usuario',
    'Cedula',
    'Email',
    '',
];

@endphp
@section('plugins.BsCustomFileInput', true)
@can('user.create')
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Nuevo usuario" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalusuario" class="float-right" />
    &nbsp;&nbsp;
    <x-adminlte-button label="Cargar usuarios por CSV" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalimport" class="float-right" />
</div>
@endcan
{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach($datos as $dato)
        <tr>
            <td>{{ $dato->id }}</td>
            <td>{{ $dato->name }}</td>
            <td>{{ $dato->username }}</td>
            <td>{{ $dato->cedula }}</td>
            <td>{{ $dato->email }}</td>
            <td>
                @can('user.edit')
                <a href="{{route('user.edit',['id'=>$dato->id])}}" class="btn btn-xs btn-default text-primary mx-1 shadow">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>
                @endcan
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="modalusuario" title="Agregar nuevo usuario" icon="fas fa-user-plus" size="lg">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div class="row">
            <div class="col">
                <x-input-label for="name" :value="__('Name')" />
                <x-adminlte-input id="name" name="name"  type="text" required autofocus
                    fgroup-class="col-md-12" autocomplete="name" :value="old('name')" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="col">
                <!-- Username -->
                <x-input-label for="username" :value="__('Usuario')" />
                <x-adminlte-input id="username" name="username"  type="text" required autofocus
                    fgroup-class="col-md-12" autocomplete="username" :value="old('username')"  >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>
        </div>
        <div class="row">
            <!-- Cedula -->
            <div class="col">
                <x-input-label for="cedula" :value="__('Cedula')" />
                <x-adminlte-input id="cedula" name="cedula" type="text" required autofocus
                    fgroup-class="col-md-12" autocomplete="cedula" :value="old('cedula')" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-address-card"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
            </div>
            <!-- Email -->
            <div class="col">
                <div class="row">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-adminlte-input id="email" name="email" type="email"  autofocus
                        fgroup-class="col-md-12" autocomplete="email" :value="old('email')"  >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <!-- Password -->
                    <x-input-label for="password" :value="__('Clave')" />
                    <x-adminlte-input id="password" name="password"  type="password" required autofocus
                        fgroup-class="col-md-12" autocomplete="new-password" :value="old('password')" >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-key"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="col">
                <!-- Confirm Password -->
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-adminlte-input id="password_confirmation" 
                                    type="password"
                                    name="password_confirmation"
                                    fgroup-class="col-md-12" required autocomplete="new-password">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-primary">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </x-slot>
                    </x-adminlte-input>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <div class="row-md-12">
            @can('user.create')
            <x-adminlte-button type="submit" label="Registrar usuario" theme="primary" icon="fas fa-user-plus"/>
            @endcan
        </div>
    </form>

</x-adminlte-modal>

<x-adminlte-modal id="modalimport" title="Importar listado de usuarios" icon="fas fa-file-upload" size="lg">
    <form action="{{route('user.import')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row-md-12">
            <x-adminlte-input-file required name="user_import" igroup-size="sm" placeholder="Choose a file...">
                <x-slot name="f">
                    <div class="input-group-text bg-lightblue">
                        <i class="fas fa-upload"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-file>
        </div>
        @can('user.create')
        <x-adminlte-button type="submit" label="Importar datos" theme="primary" icon="fas fa-file-import"/>
        @endcan
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