@extends('adminlte::page')
@section('title','Dashboard')
@section('content_header')
    <h1><li class="fas fa-door-open"></li> Administración de ingresos y salidas <li class="fas fa-door-closed"></li> </h1>
    <h3>Fecha: {{date('Y-m-d')}}</h3>
@endsection
@section('content')
    @php
        $heads = [
            'ID','ingreso','hora','vehiculo','ingreso','cedula','nombre','estado','salida','hora de salida','' ];
    @endphp
<x-adminlte-datatable id="table1" :heads="$heads">
  
</x-adminlte-datatable>
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
@stop