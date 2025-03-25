@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Title & Ask Question Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Questions</h2>
        <a href="{{ route('questions.create') }}" class="btn btn-primary">Ask a Question</a>
    </div>

    <!-- Questions List -->
    <div class="list-group">
        @foreach ($questions as $question)
        <div class="question-item d-flex justify-content-between align-items-start">
            <!-- Left: Votes & Answers -->
            <div class="question-stats text-center">
                <div class="votes">{{ $question->votes }} votes</div>
                <div class="answers {{ $question->answers->count() > 0 ? 'answered' : '' }}">
                    {{ $question->answers->count() }} answers
                </div>
                <div class="views">{{ $question->views }} views</div>
            </div>

            <!-- Middle: Question Details -->
            <div class="question-details flex-grow-1">
                <h5 class="mb-1">
                    <a href="{{ route('questions.show', $question->id) }}" class="question-title">
                        {{ $question->title }}
                    </a>
                </h5>
                <p class="question-summary">
                    {{ Str::limit(strip_tags($question->description), 150, '...') }}
                </p>
                <div class="question-meta">
                    <span class="text-muted">Asked {{ $question->created_at->diffForHumans() }}</span> |
                    <span class="text-muted">By <strong>{{ $question->user ? $question->user->name : 'Unknown' }}</strong></span>
                </div>
            </div>

            <!-- Right: Tags -->
            <div class="question-tags">
                @if ($question->tags)  <!-- Check if tags exist -->
                    @foreach ($question->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                @else
                    <span class="text-muted">No tags</span>
                @endif
            </div>

        </div>
        @endforeach
    </div>
</div>

<!-- CSS (Styled Like Stack Overflow) -->
<style>
    /* Question List Styling */
    .question-item {
        display: flex;
        background: #fff;
        border-bottom: 1px solid #ddd;
        padding: 15px;
    }

    .question-stats {
        min-width: 80px;
        font-size: 14px;
        color: #6c757d;
    }

    .question-stats div {
        margin-bottom: 5px;
    }

    .question-stats .answered {
        font-weight: bold;
        color: #28a745;
    }

    .question-details {
        margin-left: 15px;
    }

    .question-title {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .question-title:hover {
        text-decoration: underline;
    }

    .question-summary {
        font-size: 14px;
        color: #555;
    }

    .question-meta {
        font-size: 12px;
        color: #6c757d;
    }

    .question-tags {
        display: flex;
        gap: 5px;
    }

    .question-tags .badge {
        font-size: 12px;
        padding: 5px;
    }
</style>
@endsection
