@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    @foreach ($club as $clubdat)
        <h1>Editar datos de: {{$clubdat->nombre_club}} </h1>
    @endforeach
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
    <form action="" method="post">
        {{$club}}{{$id}}
        @csrf
        @foreach ($club as $clubdat)
            <div class="col">
                <x-adminlte-input style="width:100%!important" name="nombre" value="{{$clubdat->nombre_club}}" required label="Nombre del club"/>
            </div>  
            <div class="col">
                <x-adminlte-input style="width:100%!important" name="direccion" value="{{$clubdat->direccion}}" required label="Dirección del club"/>
            </div>  
            <div class="col">
                <x-adminlte-input style="width:100%!important" name="telefono" value="{{$clubdat->telefono}}" required label="Telefono del club"/>
            </div>  
            <div class="col">
                <x-adminlte-input style="width:100%!important" name="email1" value="{{$clubdat->email1}}" required label="Email del club"/>
            </div>  
        @endforeach             
        <hr>
        @can('user.edit')
            <x-adminlte-button type="submit" label="Actualizar datos del club" theme="primary" icon="fas fa-key"/>
        @endcan
    </form>
@endsection
