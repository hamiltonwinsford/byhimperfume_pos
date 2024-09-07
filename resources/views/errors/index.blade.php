@extends('layouts.error')

@section('main')
    <div class="error-page text-center">
        <h1 class="display-4 text-danger">Oops!</h1>
        <p class="lead">{{ $exception ?? 'Something went wrong.' }}</p>


        @role('admin')

        <a href="{{ route('home.admin') }}" class="btn btn-primary mt-4">Go back to Home</a>
        @endrole

        @role('staff')
        <a href="{{ route('home') }}" class="btn btn-primary mt-4">Go back to Home</a>
        @endrole
    </div>
@endsection
