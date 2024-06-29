@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="card">
            <div class="card-header">
                <h2>Create User</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">

                    {{-- Cross Site Request Forgering --}}
                    @csrf
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

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
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


    </div>
@endsection
