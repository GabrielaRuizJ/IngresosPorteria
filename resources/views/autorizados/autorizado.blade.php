@extends('adminlte::page')
@section('title','Autorizados')
@section('content_header')
    <h1><li class="fas fa-user-check"></li> Listado de personas autorizadas</li> </h1>
@endsection
@php
    $heads = ['ID','cedula','nombre','nombre ','Fecha inicio de ingreso','Fecha fin de ingreso','Fecha de registro','' ];
    $contador = 0;
@endphp

@section('content')
@can('autorizado.create')
    <x-adminlte-button label="Nuevo autorizado" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#myModal" class="float-right"/>
@endcan
<br><br>
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
   @foreach($autorizados as $datautorizado)
        @php
            $contador++;
        @endphp
        <tr>
            <td>{{ $datautorizado->id }}</td>
            <td>{{ $datautorizado->cedula_autorizado }}</td>
            <td>{{ $datautorizado->nombre_autorizado }}</td>
            <td>{{ $datautorizado->nombre_autoriza }}</td>
            <td>{{ $datautorizado->fecha_ingreso }}</td>
            <td>{{ $datautorizado->fecha_fin_ingreso }}</td>
            <td>{{ $datautorizado->created_at }}</td>
            <td>
                @can('autorizado.delete')
                    <form method="POST" action="{{route('autorizado.delete')}}" id="formElimAut{{$contador}}" name="formElimAut{{$contador}}" >
                        @csrf
                        @method('delete')
                        <input type="hidden" name="datIdAut" id="datIdAut" value="{{$datautorizado->id}}">
                        <input type="hidden" name="datFIAut" id="datFIAut" value="{{$datautorizado->fecha_ingreso}}">
                        <input type="hidden" name="datFFIAut" id="datFFIAut" value="{{$datautorizado->fecha_fin_ingreso}}">
                    </form>
                    <button onclick="elimAuth({{$contador}})" type="button" id="btnElimAut{{$contador}}" name="btnElimAut{{$contador}}" class="btn text-dark bg-light border border-danger"><i class="fas fa-times"></i> </button>
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
                        <x-adminlte-input type="text" name="docautoriza" id="docautoriza" readonly required label="Cédula de quien autoriza" fgroup-class="col-md-12" value="{{$cedulaId}}" />
                    </div>
                    <div class="col">
                        <x-adminlte-input type="text" name="nomautoriza" id="nomautoriza" readonly required label="Nombre de quien autoriza" fgroup-class="col-md-12" value="{{$nameId}}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="fechaIngreso">Fecha inicio de autorización</label>
                        <input type="date" class="form-control" value="{{date("Y-m-d")}}" id="fechaIngreso" name="fechaIngreso" required fgroup-class="col-md-12" />
                    </div>
                    <div class="col">
                        <label for="fechaFIngreso">Fecha fin de autorización</label>
                        <input type="date" class="form-control" value="{{date("Y-m-d")}}" id="fechaFIngreso" name="fechaFIngreso" required fgroup-class="col-md-12" />
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