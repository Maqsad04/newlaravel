@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Questions</h1>

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
                <th>Status</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->title }}</td>
                    <td>{{ $question->description }}</td>
                    <td>
                        @if ($question->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif ($question->status == 'accepted')
                            <span class="badge bg-success">Accepted</span>
                        @elseif ($question->status == 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $question->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">You haven't submitted any questions yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection