@extends('adminlte::page')
@section('title','Clubes')
@section('content_header')
    <h1><li class="fas fa-hotel"></li>Clubes para canje</h1>
@endsection
@section('content')
    @php
        $heads = [
            'ID','nombre','pbx','correo','estado'];
    @endphp
<br><br>
    <x-adminlte-datatable id="tableclub" :heads="$heads" with-buttons>
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