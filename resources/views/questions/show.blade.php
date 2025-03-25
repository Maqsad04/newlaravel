@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary mb-4">Back to Questions</a>

    <!-- Question Card -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h1 class="h4 mb-3">{{ $question->title }}</h1>
            <p class="text-muted small mb-2">
                Asked by <strong>{{ $question->user->name }}</strong>
                <span class="text-muted">• {{ $question->created_at->diffForHumans() }}</span>
            </p>
            <p class="card-text">{{ $question->description }}</p>

            @if (auth()->id() === $question->user_id)
                <!-- Toggle Comments Button -->
                <form action="{{ route('questions.toggleComments', $question) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-warning">
                        {{ $question->comments_disabled ? 'Enable Comments' : 'Disable Comments' }}
                    </button>
                </form>
            @endif

            @if (auth()->id() === $question->user_id || auth()->user()->hasRole('admin'))
                <!-- Delete Question Button -->
                <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this question?')">
                        Delete Question
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Answers Section -->
    <h5 class="mb-3">Answers ({{ $question->answers->count() }})</h5>

    @foreach ($question->answers as $answer)
        <div class="card mb-3 shadow-sm {{ $answer->highlighted ? 'border-success' : '' }}">
            <div class="card-body">
                <p class="mb-1">
                    <strong>{{ $answer->user->name }}</strong>
                    <span class="text-muted small">• {{ $answer->created_at->diffForHumans() }}</span>
                </p>
                <p class="card-text">{{ $answer->content }}</p>

                @if (auth()->id() === $answer->user_id || auth()->user()->role === 'admin')
                    <!-- Delete Answer Button -->
                    <form action="{{ route('answers.destroy', $answer) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this answer?')">
                            Delete Answer
                        </button>
                    </form>
                @endif

                @if (auth()->id() === $question->user_id && !$answer->highlighted)
                    <!-- Highlight Answer Button -->
                    <form action="{{ route('answers.highlight', $answer) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        
                        <button type="submit" class="btn btn-sm btn-success">
                           this is true answer
                        </button>
                    </form>
                @endif

                @if ($answer->highlighted )
                   
                    <form action="{{ route('answers.unhighlight', $answer) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        @if (auth()->id() === $question->user_id && $answer->highlighted)
                        <button type="submit" class="btn btn-sm btn-warning">
                            this is not true answer
                        </button>  @endif
                        <p style="text-align:right; color: green">this is true answer</p>
                    </form>
                @endif 
            </div>
        </div>
    @endforeach

    <!-- Add Answer Form -->
    @if (!$question->comments_disabled)
        @auth
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="mb-3">Your Answer</h5>
                    <form action="{{ route('answers.store', $question) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" class="form-control" rows="5" required placeholder="Write your answer here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Answer</button>
                    </form>
                </div>
            </div>
        @endauth
    @else
        <p class="text-muted">Commenting is disabled for this question.</p>
    @endif


    
</div>
@endsection