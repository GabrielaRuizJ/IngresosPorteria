@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><li class="fas fa-people-arrows"></li> Listado de roles</h1>
@stop

@section('content')

@php
$heads = [
    'ID',
    'Nombre',
    'Acciones',
];
@endphp
@role("Admin")
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Nuevo rol" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal" class="float-right"/>
</div>
@endrole
<div class="container">
    @if ($errors->any())
        <div class="alert alert-warning" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        </div>
    @endif
</div>
{{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>
                    <a href="{{route('role.edit',['id'=>$role->name])}}" class="btn btn-xs btn-default text-primary mx-1 shadow">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    <x-adminlte-modal id="myModal" title="Nuevo registro de rol" theme="primary"
    icon="fas fa-people-arrows" size='lg' disable-animations>
    <form action="{{route('role.create')}}" method="post">
        @csrf
            <div class="row">
                <x-adminlte-input name="nombre" label="Nombre del rol" placeholder="Especificar el nombre del nuevo rol"
                    fgroup-class="col-md-6" disable-feedback/>
            </div>
            <hr>
            <label>*Listado de permisos disponibles para agregarle al rol*</label>
            @foreach ($permisos as $indice => $permiso)
                @if ( ($indice == 0) || ($indice % 2 == 0) )
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" name="id_permiso[]" value="{{ $permiso->id }}">
                                <label>{{ $permiso->name}}</label>
                            </div>
                        </div>
                @else
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" name="id_permiso[]" value="{{ $permiso->id }}">
                                <label>{{ $permiso->name}}</label>
                            </div> 
                        </div>
                    </div> 
                @endif
                   
            @endforeach
        <x-adminlte-button type="submit" label="Guardar rol" theme="primary" icon="fas fa-people-arrows"/>
    </form>
</x-adminlte-modal>


@stop

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
@stop