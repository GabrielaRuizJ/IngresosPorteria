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
    <form action="{{route('role.update',['id'=>$role->name])}}" method="post">
        @csrf
            <div class="col">
                <x-adminlte-input readonly name="nombre" value="{{$role->name}}" required label="Nombre del rol"/>
            </div>
            <hr>
            <label>*Permisos disponibles para agregar al rol {{$role->name}}*</label>
            <div class="col">     
                @foreach ($permisosAsignados as $permissionrole)
                    <div class="form-check">
                        <input type="checkbox" checked name="id_permiso[]" value="{{ $permissionrole->name }}">
                        <label>{{ $permissionrole->name}}</label>
                    </div> 
                @endforeach
                @foreach ($permisosDisponibles as $permissiondispo)
                    <div class="form-check">
                        <input type="checkbox" name="id_permiso[]" value="{{ $permissiondispo->name }}">
                        <label>{{ $permissiondispo->name}}</label>
                    </div> 
                @endforeach
            </div>        
        <hr>
        @role('Admin')
            <x-adminlte-button type="submit" label="Actualizar datos del rol" theme="primary" icon="fas fa-key"/>
        @endrole
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