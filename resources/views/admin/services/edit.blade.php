@extends('layouts.app')

@section('content')

    <div class="container">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.services.index') }}">&larr; Back to
            Services</a>

        <div class="card">
            <div class="card-header">
                <h2>Edit service</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control mb-3" name="name" id="name"
                        value="{{ $service->name }}">
                    <div class="mb-3 d-flex justify-content-center">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>



@endsection
