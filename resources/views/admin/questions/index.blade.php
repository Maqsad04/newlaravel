@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pending Questions</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Body</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->title }}</td>
                    <td>{{ Str::limit($question->description, 50, '...') }}</td>
                    <td>
                        <form action="{{ route('admin.questions.accept', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-success btn-sm">Accept</button>
                        </form>
                        <form action="{{ route('admin.questions.reject', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No pending questions.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection