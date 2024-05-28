@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1><li class="fas fa-user-check"></li> Listado de personas autorizadas</li> </h1>
@endsection
@php
    $heads = ['ID','cedula','nombre','nombre ','Fecha de ingreso','Fecha de registro','' ];
@endphp

@section('content')
@can('autorizado.create')
    <x-adminlte-button label="Nuevo autorizado" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal" class="float-right"/>
@endcan
<br><br>
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
   @foreach($autorizados as $datautorizado)
        <tr>
            <td>{{ $datautorizado->id }}</td>
            <td>{{ $datautorizado->cedula_autorizado }}</td>
            <td>{{ $datautorizado->nombre_autorizado }}</td>
            <td>{{ $datautorizado->nombre_autoriza }}</td>
            <td>{{ $datautorizado->fecha_ingreso }}</td>
            <td>{{ $datautorizado->fecha_registro }}</td>
            <td>
                @can('autorizado.delete')
                <a data-toggle="modal" data-target="#modalEliminarAut" onclick="autorizadoElim('{{$datautorizado->id}}','{{$datautorizado->cedula_autorizado}}','{{$datautorizado->nombre_autorizado}}','{{$datautorizado->nombre_autoriza}}','{{$datautorizado->fecha_ingreso}}')" href="#" class="btn btn-lg btn-default text-danger mx-1 shadow">
                    <i class="fa fa-lg fa-fw fas fa-door-closed"></i>
                </a>
                @endcan
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="myModal" title="Nuevo registro de autorizado" theme="primary"
        icon="fas fa-user-check" size='lg' disable-animations>
        <form action="{{route('autorizado.create')}}" id="formAutoriza" method="POST">
            @csrf
                <div class="row">
                    <div class="col">
                        <x-adminlte-input type="text" name="docautorizado" id="docautorizado" required label="Cédula" fgroup-class="col-md-12" />
                    </div>
                    <div class="col">
                        <x-adminlte-input type="text" name="nomautorizado" id="nomautorizado" required label="Nombre" fgroup-class="col-md-12" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <x-adminlte-input type="text" name="docautoriza" id="docautoriza" required label="Cédula de quien autoriza" fgroup-class="col-md-12" />
                    </div>
                    <div class="col">
                        <x-adminlte-input type="text" name="nomautoriza" id="nomautoriza" required label="Nombre de quien autoriza" fgroup-class="col-md-12" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="fechaIngreso">Fecha de ingreso</label>
                        <input type="date" class="form-control" value="{{date("Y-m-d")}}" id="fechaIngreso" name="fechaIngreso" required fgroup-class="col-md-12" />
                    </div>
                </div>
        </form>
        <hr>
        <div class="row-md-12">
            @can('autorizado.create')
                <x-adminlte-button id="btnGuardarAutoriza" style="width: 100%" type="submit" label=" Guardar autorización" theme="primary" icon="fas fa-save"/>
            @endcan
        </div>
</x-adminlte-modal>
    
<x-adminlte-modal id="modalEliminarAut" title="Eliminar registro de autorización" theme="primary"
        icon="fas fa-user-check" size='lg' disable-animations>
        <form action="{{route('autorizado.delete')}}" id="formElimAut" method="POST">
            @csrf
            @method('DELETE')
                <div class="col">
                    <x-adminlte-input readonly type="hidden" name="datIdAut" id="datIdAut" required fgroup-class="col-md-12" />
                </div>
                <div class="row">
                    <div class="col">
                        <x-adminlte-input readonly type="text" name="datCedulaAut" id="datCedulaAut" required label="Cedula del autorizado" fgroup-class="col-md-12" />
                    </div>
                    <div class="col">
                        <x-adminlte-input readonly type="text" name="datNomAAut" id="datNomAAut" required label="Nombre del autorizado" fgroup-class="col-md-12" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <x-adminlte-input readonly type="text" name="datNomQAut" id="datNomQAut" required label="Nombre de quien autoriza" fgroup-class="col-md-12" />
                    </div>
                    <div class="col">
                        <x-adminlte-input readonly type="text" name="datFIAut" id="datFIAut" required label="Fecha de ingreso" fgroup-class="col-md-12" />
                    </div>
                </div>
        </form>
        <hr>
        <div class="row-md-12">
            @can('autorizado.delete')
                <x-adminlte-button id="btnElimAut" style="width: 100%" type="submit" label="Eliminar autorización" theme="primary" icon="fas fa-save"/>
            @endcan
        </div>
</x-adminlte-modal> 
   
@endsection


@section('js')
    <script src="{{asset('/js/validacionAutorizados.js') }}"></script>
    @if(session()->has('mensaje'))
    <script>
        Swal.fire({
            title:'Correcto',
            icon:'success',
            text:"{{session('mensaje')}}"
        });
    </script>
    @endif
    @if(session()->has('errormensaje'))
    <script>
        Swal.fire({
            title:'Error',
            icon:'error',
            text:"{{session('errormensaje')}}"
        });
    </script>
    @endif
@stop