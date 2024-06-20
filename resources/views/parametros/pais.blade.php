@extends('adminlte::page')
@section('title','Países')
@section('content_header')
    <h1>Listado de paises</h1>
@endsection
@section('content')
    @php
        $heads = [
            'ID','nombre del país','' ];
    @endphp
    @section('plugins.BsCustomFileInput', true)
@can('pais.create')
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Nuevo pais" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalpais" class="float-right" />
    &nbsp;&nbsp;
    <x-adminlte-button label="Cargar archivo con paises" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalimport" class="float-right" />
</div>
@endcan

<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach ($paises as $pais)
        <tr>
            <td>{{$pais->id}}</td>
            <td>{{$pais->nombre_pais}}</td>
            <td>
                @can('pais.edit')
                @endcan
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
<x-adminlte-modal id="modalpais" title="Agregar nuevo país" icon="fas fa-plus" size="lg">
    <form action="{{route('pais.store')}}" method="post">
        @csrf
        <div class="row-md-12">
            <x-adminlte-input required name="nombre_pais" label="Nombre del pais" placeholder="Colombia"/>
        </div>
        <x-adminlte-button type="submit" label="Guardar pais" theme="primary" icon="fas fa-key"/>
    </form>
</x-adminlte-modal>
<x-adminlte-modal id="modalimport" title="Importar listado de paises" icon="fas fa-plus" size="lg">
    <form action="{{route('pais.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row-md-12">
            <x-adminlte-input-file required name="paises_import" igroup-size="sm" placeholder="Choose a file...">
                <x-slot name="f">
                    <div class="input-group-text bg-lightblue">
                        <i class="fas fa-upload"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-file>
        </div>
        @can('pais.create')
            <x-adminlte-button type="submit" label="Guardar listado de paises" theme="primary" icon="fas fa-key"/>
        @endcan
    </form>
</x-adminlte-modal>

@endsection
@section('js')
    @if(session()->has('mensaje'))
    <script>
        Swal.fire({
            title:'Correcto',
            icon:'success',
            text:"{{session('mensaje')}}"
        });
    </script>
    @endif
@endsection