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
    <form action="{{route('club.create')}}" id="syncClubes" method="post">
        @csrf
        <x-adminlte-button type="button" id="btnSyncClubes" label="Sincronizar datos" theme="primary" icon="fas fa-sync" class="float-right" />
    </form>
@endcan
<br><br>
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
@section('js')
    <script src="{{asset('/js/sincronizarClubes.js') }}"></script>
    @if(session()->has('mensaje'))
    <script>
        const contenidoHTMLRes = decodeEntities("{{session('mensaje')}}")
        Swal.fire({
            title:'Resultlado de sincronizacion',
            icon:'info',
            html:contenidoHTMLRes
        });
    </script>
    @endif
@stop