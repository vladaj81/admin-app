@extends('layouts.app')

{{-- Customize layout sections --}}

@section('content_header_title', 'Home')

{{-- Content body: main page content --}}

@section('content')
    <p>Welcome to the home page.</p>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@endpush