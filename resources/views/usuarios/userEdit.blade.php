@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1>Editar datos del usuario</h1>
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
    <form action="{{route('user.update',['id'=>$user->id])}}" method="post">
        @csrf
            
            <div class="col">
                    <div class="row">
                    <x-adminlte-input name="nombre" value="{{$user->name}}" required label="Nombre del usuario"/>&nbsp;&nbsp;                             
                    <x-adminlte-input name="username" value="{{$user->username}}" required label="Usuario"/>            
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <x-adminlte-input name="cedula" value="{{$user->cedula}}" required label="Cedula del usuario"/>&nbsp;&nbsp;           
                    <x-adminlte-input name="email" value="{{$user->email}}" required label="Email del usuario"/>    
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="form-check">
                        <input type="checkbox" name="estado" 
                            @if ( $user->estado == 1)
                                {{'checked '}}
                            @endif
                            >
                            @if ( $user->estado == 1)
                                <label>{{'Activo'}}</label>   
                            @else    
                                <label>{{'Inactivo'}}</label> 
                            @endif
                         
                    </div>  
                </div>
            </div>
            <hr>
            <label>*Roles disponibles*</label>
            <div class="col">     
                @foreach ($roles as $roluser)
                    <div class="form-check">
                        <label>{{ $roluser->name }}</label>
                        <input type="checkbox" name="id_rol[]" value="{{ $roluser->name }}" 
                            {{ in_array($roluser->id, $roles_usuario) ? 'checked' : '' }}>
                        
                    </div> 
                @endforeach
            </div>        
        <hr>
        @can('user.edit')
            <x-adminlte-button type="submit" label="Actualizar usuario" theme="primary" icon="fas fa-key"/>
        @endcan
    </form>
@endsection
