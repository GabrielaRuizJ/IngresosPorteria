@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1>Editar el rol</h1>
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
    <form action="{{route('permiso.update',['id'=>$permiso->id])}}" method="post">
        @csrf
            <div class="row">
                <x-adminlte-input readonly name="nombre" value="{{$permiso->name}}" required label="Nombre del permiso"/>
            </div>
            <hr>
            <label>*Roles disponibles para agregar al permiso {{$permiso->name}}*</label>

            @foreach ($rolesAsignados as $permissionrole => $nombre)
                    <div class="form-check">
                        <input type="checkbox" checked name="id_rol[]" value="{{$nombre->name }}">
                        <label>{{ $nombre->name}}</label>
                    </div> 
            @endforeach
            @foreach ($rolesDisponibles as $roledispo)
                    <div class="form-check">
                        <input type="checkbox" name="id_rol[]" value="{{ $roledispo->name }}">
                        <label>{{ $roledispo->name}}</label>
                    </div> 
            @endforeach
        <hr>
        <x-adminlte-button type="submit" label="Actualizar datos del permiso" theme="primary" icon="fas fa-key"/>
    </form>
@endsection

@section('js')
    @if (isset($mensaje))
    <script>
        Swal.fire({
            title:'Correcto',
            icon:'success',
            text:"{{$mensaje}}"
        });
    </script>
    @endif
@endsection