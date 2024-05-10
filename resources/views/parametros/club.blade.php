@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1><li class="fas fa-hotel"></li> Listado de clubes para canje</h1>
@endsection
@section('content')
    @php
        $heads = [
            'ID','nombre','pbx','correo','estado'];
    @endphp
@can('club.create')
<div class="row float-right" style="margin-bottom: 10px">
    <x-adminlte-button label="Nuevo club" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalClub" class="float-right" />
</div>
@endcan

    <x-adminlte-datatable id="tableclub" :heads="$heads">
        @foreach ($clubes as $club)
        <tr>
            <td>{{$club->id}}</td>
            <td>{{$club->club}}</td>
            <td>{{$club->pbx}}</td>
            <td>{{$club->correo}}</td>
            <td>
                @if ($club->estado == 1)
                    <label>Activo</label>
                @else
                    <label>Inactivo</label>
                @endif
            </td>
        </tr>
        @endforeach
    </x-adminlte-datatable>
@endsection
