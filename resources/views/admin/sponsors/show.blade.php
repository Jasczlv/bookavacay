@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.sponsors.index') }}">&larr; Back to
                Sponsors</a>
        </div>
        <div class="container">
            <h1>{{ $sponsor->tier }}</h1>
            <h4>Hours: {{ $sponsor->hours }}</h4>
            <h4>Price: {{ $sponsor->price }}</h4>
        </div>
        <div class="container d-flex justify-content-center align-items-center gap-2">
            <a type="button" class="btn btn-warning" href="{{ route('admin.sponsors.edit', $sponsor) }}">Edit</a>
            <form class="delete-form" action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </section>
@endsection
