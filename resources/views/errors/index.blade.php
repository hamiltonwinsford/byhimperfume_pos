@extends('layouts.error')

@section('main')
    <div class="error-page text-center">
        <h1 class="display-4 text-danger">Oops!</h1>
        <p class="lead">{{ $exception ?? 'Something went wrong.' }}</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-4">Go back to Home</a>
    </div>
@endsection
