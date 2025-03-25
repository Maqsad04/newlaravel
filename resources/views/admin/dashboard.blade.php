@extends('layouts.app')

@section('content')
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.jsx', 'resources/css/app.css'])

    <!-- Pass data to React via a script tag -->
    <script>
        window.adminData = {
            stats: {
                totalUsers: {{ $totalUsers }},
                totalQuestions: {{ $totalQuestions }},
                deletedQuestions: {{ $deletedQuestions }},
            },
            users: @json($users),
            questions: @json($allQuestions),
            chartData: @json($chartData),
            
        };
        
    </script>

    <div id="admin-dashboard">
        <!-- <p>Loading...</p> -->
    </div>
@endsection