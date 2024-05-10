@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1><li class="fas fa-user-check"></li> Listado de canjes registrados</li> </h1>
@endsection
@php
    $heads = ['ID','club','cedula','nombre','Fecha de inicio','fecha fin','fecha de creación' ];
@endphp

@section('content')
<x-adminlte-datatable id="table1" :heads="$heads">
   @foreach($canjes as $datcanjes)
        <tr>
            <td>{{ $datcanjes->id }}</td>
            <td>{{ $datcanjes->nombre_club }}</td>
            <td>{{ $datcanjes->cedula_canje }}</td>
            <td>{{ $datcanjes->nombre_canje }}</td>
            <td>{{ $datcanjes->fecha_inicio_canje }}</td>
            <td>{{ $datcanjes->fecha_fin_canje }}</td>
            <td>{{ $datcanjes->created_at }}</td>
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