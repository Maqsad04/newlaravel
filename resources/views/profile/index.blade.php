@extends('layouts.app')

@section('content')
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.jsx'])

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.profileData = {
            user: @json($user),
            questions: @json($questions),
        };
        console.log('Profile Data:', window.profileData);
    </script>

    <div id="user-profile">
        <p>Loading...</p>
    </div>
@endsection