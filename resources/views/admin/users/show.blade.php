@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row card">

            <div class="col-auto">
                <label for="email" class="fw-bold">Email:</label>
                <p id="email">{{ $user->email }}</p>
            </div>
            <div class="col-auto">
                <label for="name" class="fw-bold">Name:</label>
                @if ($user->name !== null)
                    <p id="name">
                        {{ $user->name }}
                    </p>
                @else
                    <p id="name">Not Set</p>
                @endif
            </div>
            <div class="col-auto">
                <label for="surname" class="fw-bold">Surname:</label>
                @if ($user->surname !== null)
                    <p id="surname">
                        {{ $user->surname }}
                    </p>
                @else
                    <p id="surname">Not Set</p>
                @endif
            </div>
            <div class="col-auto">
                <label for="date_of_birth" class="fw-bold">Date of birth:</label>
                @if ($user->date_of_birth !== null)
                    <p id="date_of_birth">
                        {{ $user->date_of_birth }}
                    </p>
                @else
                    <p id="date_of_birth">Not Set</p>
                @endif
            </div>
        </div>
        <button class="btn btn-primary mt-4">Edit</button>

    </div>
@endsection
