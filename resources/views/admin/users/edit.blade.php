@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-center align-items-center">
            <p>Create a new user</p>
        </div>

        @if ($errors->any())
            <div class="alert
                                    alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">

            {{-- Cross Site Request Forgering --}}
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="David">
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Surname*</label>
                <input type="text" name="surname" class="form-control" id="surname" placeholder="White">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email"
                    placeholder="david.white@email.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of birth*</label>
                <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" placeholder="">
            </div>

            <div class="d-flex justify-content-center py-4">
                <button class="btn my-btn-edit">Update</button>
            </div>
            <form action="{{ route('admin.useres.destroy', $usere) }}" method="POST">
                @method('DELETE')
                @csrf

                <button class="btn btn-link link-danger">Trash</button>

            </form>
        </form>
    </div>
@endsection
