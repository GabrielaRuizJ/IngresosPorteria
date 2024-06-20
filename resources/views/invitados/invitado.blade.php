@extends('adminlte::page')
@section('title','Invitados')
@section('content_header')
    <h1><li class="fas fa-user-friends"></li> Listado de invitados registrados</li> </h1>
@endsection
@php
    $heads = ['ID','documento anfitrion','nombre anfitrion','documento invitado','nombre invitado','fecha de ingreso','fecha de creación' ];
@endphp

@section('content')
<x-adminlte-datatable id="table1" :heads="$heads" with-buttons>
   @foreach($invitados as $datinvitado)
        <tr>
            <td>{{ $datinvitado->id }}</td>
            <td>{{ $datinvitado->doc_anfitrion }}</td>
            <td>{{ $datinvitado->nombre_anfitrion }}</td>
            <td>{{ $datinvitado->doc_invitado }}</td>
            <td>{{ $datinvitado->nombre_invitado }}</td>
            <td>{{ $datinvitado->fecha_ingreso }}</td>
            <td>{{ $datinvitado->created_at }}</td>
        </tr>
    @endforeach
</x-adminlte-datatable>
@endsection