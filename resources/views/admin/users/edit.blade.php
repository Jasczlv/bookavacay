@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-center align-items-center">
            <p>Update user</p>
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

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">

            {{-- Cross Site Request Forgering --}}
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="David"
                    value="{{ $user->name }}">
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Surname*</label>
                <input type="text" name="surname" class="form-control" id="surname" placeholder="White"
                    value="{{ $user->surname }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="david.white@email.com"
                    value="{{ $user->email }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of birth*</label>
                <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" placeholder=""
                    value="{{ $user->date_of_birth }}">
            </div>

            <div class="d-flex justify-content-center py-4">
                <button class="btn btn-primary">Update</button>

            </div>

        </form>
    </div>
@endsection
