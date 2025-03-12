@extends('layouts.app')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

                <!-- @foreach (auth()->user()->notifications as $notification)
                    <div class="alert alert-info">
                        {{ $notification->data['message'] }}
                    </div>
                @endforeach -->
            </div>
        </div>
    </div>
</div>

