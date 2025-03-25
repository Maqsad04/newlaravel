@extends('layouts.app')

@section('content')
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.jsx'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.adminData = {
            questions: @json($questions),
        };
    </script>

    <div id="admin-questions">
        <p>Loading...</p>
    </div>
@endsection