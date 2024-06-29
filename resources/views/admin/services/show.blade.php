@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <a type="button" class="btn btn-primary mt-4 mb-3" href="{{ route('admin.services.index') }}">&larr; Back to all
                services</a>
        </div>
        <div class="container py-5">
            <h2>{{ $service->name }}</h2>
        </div>
        <div class="container">
            <a type="button" class="btn btn-warning mt-4 mb-2" href="{{ route('admin.services.edit', $service) }}">Edit</a>
        </div>
        <div class="container">
            <form class="delete-form" action="{{ route('admin.services.destroy', $service) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </section>
@endsection
