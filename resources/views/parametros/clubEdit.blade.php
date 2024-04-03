@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1>Editar datos de: {{$club->nombre_club}} </h1>
@endsection
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-warning" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            </div>
        @endif
    </div>
    <form action="{{route('club.update',['id'=>$club->id])}}" method="post">
        @csrf
        @foreach ($clubdat as $clubdat)
            <div class="col">
                <x-adminlte-input required style="width:100%!important" name="nombre" value="{{$clubdat->nombre_club}}" required label="Nombre del club"/>
            </div>  
            <div class="col">
                <x-adminlte-input required style="width:100%!important" name="direccion" value="{{$clubdat->direccion}}" required label="Dirección del club"/>
            </div>  
            <div class="col">
                <x-adminlte-input required style="width:100%!important" name="telefono" value="{{$clubdat->telefono}}" required label="Telefono del club"/>
            </div>  
            <div class="col">
                <x-adminlte-input required style="width:100%!important" name="email1" value="{{$clubdat->email1}}" required label="Email del club"/>
            </div>
            <div class="col">
                <x-adminlte-select name="ciudad" label="Ciudad">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-city"></i>
                        </div>
                    </x-slot>
                    @foreach ($ciudades as $ciudad)
                        @if ($ciudad->id == $clubdat->idciudad)
                        <option selected value="{{$ciudad->id}}">{{$ciudad->nombre}}</option>
                        @else
                        <option value="{{$ciudad->id}}">{{$ciudad->nombre}}</option>
                        @endif
                    @endforeach
                </x-adminlte-select>  
            </div>
        @endforeach             
        <hr>
        @can('club.edit')
            <x-adminlte-button type="submit" label="Actualizar datos del club" theme="primary" icon="fas fa-key"/>
        @endcan
    </form>
@endsection
