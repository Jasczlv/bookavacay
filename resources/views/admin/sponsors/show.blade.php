@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <a type="button" class="btn btn-primary mt-4 mb-3" href="{{ route('admin.sponsors.index') }}">&larr; Back to all sponsors</a>
    </div>
    <div class="container">
        <h1>{{ $sponsor->tier }}</h1>
        <h4>Hours: {{ $sponsor->hours }}</h4>
        <h4>Price: {{ $sponsor->price }}</h4>
    </div>
    <div class="container">
        <a type="button" class="btn btn-warning mt-4 mb-2" href="{{ route('admin.sponsors.edit',$sponsor) }}">Edit</a>
    </div>
    <div class="container">
        <form class="delete-form" action="{{ route('admin.sponsors.destroy',$sponsor) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger">Delete</button>
        </form>
    </div>
</section>

@endsection
