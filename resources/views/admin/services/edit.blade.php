@extends('layouts.app')

@section('content')

    <div class="container my-5">

        <div class="card">
            <div class="card-header text-center">
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
