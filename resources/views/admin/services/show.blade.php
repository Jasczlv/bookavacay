@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.services.index') }}">&larr; Back to
                Services</a>
        </div>
        <div class="container py-5">
            <h2>{{ $service->name }}</h2>
        </div>

        {{-- Edit and delete buttons --}}
        <div class="container d-flex justify-content-center align-items-center gap-2">
            <a type="button" class="btn btn-warning" href="{{ route('admin.services.edit', $service) }}">Edit</a>
            <form class="delete-form" action="{{ route('admin.services.destroy', $service) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </section>
@endsection
