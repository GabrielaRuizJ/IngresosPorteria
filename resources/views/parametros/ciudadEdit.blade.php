@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1>Administración de ciudades</h1>
@endsection
@section('content')
    <form action="{{route('ciudad.update',3)}}" method="post">
        @csrf
        <div class="row">
            @foreach ($ciudades as $ciudad)
                <x-adminlte-input style="width:100%!important" name="nombre" value="{{$ciudad->nombreciudad}}" required label="Nombre de la ciudad"/>
            @endforeach
            <select name="id_pais" class="form-control">
                @foreach ($ciudades as $ciudad1)
                    <option selected value="{{$ciudad1->idpais}}">{{$ciudad1->pais}}</option>
                 @endforeach 
                
                @foreach ($paises as $pais)
                    <option value="{{$pais->id}}">{{$pais->nombre_pais}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        @can('ciudad.edit')
            <x-adminlte-button type="submit" label="Guardar cambios" theme="primary" icon="fas fa-key"/>
        @endcan
    </form>
@endsection
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@endsection
@section('js')

@endsection