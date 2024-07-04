@extends('layouts.app')

@section('content')

    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                <h2>New Service</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control mb-3" name="name" id="name">
                    <div class="mb-3 text-center">
                        <button class="btn btn-primary">Create</button>
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
