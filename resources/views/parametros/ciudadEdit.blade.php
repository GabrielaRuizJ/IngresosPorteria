@extends('adminlte::page')
@section('title','Editar Ciudades')
@section('content_header')
    <h1>Editar ciudad</h1>
@endsection
@section('content')
    <form action="{{route('ciudad.update',['id'=>$ciudad->id])}}" method="post">
        @csrf
        <div class="row">
            @foreach ($ciudades as $ciudad)
                <x-adminlte-input fgroup-class="col-md-12"  style="width:100%!important" name="nombre" value="{{$ciudad->nombreciudad}}" required label="Nombre de la ciudad"/>
                <select name="id_pais" class="form-control">
                    @foreach ($paises as $pais)
                        @if ($pais->id == $ciudad->idpais)
                            <option selected value="{{$pais->id}}">{{$pais->nombre_pais}}</option>
                        @else
                            <option value="{{$pais->id}}">{{$pais->nombre_pais}}</option>
                        @endif
                    @endforeach
                </select>
            @endforeach
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