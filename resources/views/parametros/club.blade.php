@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1><li class="fas fa-hotel"></li> Administración de clubes</h1>
@endsection
@section('content')
    @php
        $heads = [
            'ID','nombre','direccion','telefono','email principal','ciudad', ];
    @endphp
@role('Admin')
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Nuevo club" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalClub" class="float-right" />
</div>

@endrole('Admin')
    <x-adminlte-datatable id="tableclub" :heads="$heads">
        @foreach ($clubes as $club)
        <tr>
            <td>{{$club->id}}</td>
            <td>{{$club->nombre_club}}</td>
            <td>{{$club->direccion}}</td>
            <td>{{$club->telefono}}</td>
            <td>{{$club->email1}}</td>
            <td>{{$club->ciudad}}</td>
        </tr>
        @endforeach
    </x-adminlte-datatable>
    <x-adminlte-modal id="modalClub" title="Agregar nuevo club" icon="fas fa-hotel" size="lg">
        <form action="{{route('club.create')}}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    <x-input-label for="nombre_club" :value="__('Nombre del club')" />
                    <x-adminlte-input id="nombre_club" name="nombre_club"  type="text" required autofocus
                        fgroup-class="col-md-12" autocomplete="nombre_club" :value="old('name')" >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-hotel"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-input-error :messages="$errors->get('nombre_club')" class="mt-2" />
                </div>
                <div class="col">
                    <x-input-label for="dir_club" :value="__('Direccion')" />
                    <x-adminlte-input id="dir_club" name="dir_club"  type="text" required autofocus
                        fgroup-class="col-md-12" autocomplete="dir_club" :value="old('dir_club')" >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-input-label for="tel_club" :value="__('Telefono')" />
                    <x-adminlte-input id="tel_club" name="tel_club"  type="text" required autofocus
                        fgroup-class="col-md-12" autocomplete="tel_club" :value="old('tel_club')" >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-phone"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="col">
                    <x-input-label for="email_club" :value="__('Email')" />
                    <x-adminlte-input id="email_club" name="email_club"  type="email" required autofocus
                        fgroup-class="col-md-12" autocomplete="email_club" :value="old('email_club')" >
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>
            <div class="row-md-12">
                <div-col>
                    <x-adminlte-select name="ciudad" label="Ciudad">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-city"></i>
                            </div>
                        </x-slot>
                        @foreach ($ciudades as $ciudad)
                            <option value="{{$ciudad->id}}">{{$ciudad->nombre}}</option>
                        @endforeach
                    </x-adminlte-select>
                </div-col>
            </div>
            <x-adminlte-button type="submit" label="Guardar club" theme="primary" icon="fas fa-hotel" />
        </form>
    </x-adminlte-modal>
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
@endsection