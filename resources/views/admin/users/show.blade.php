@extends('layouts.app')

@section('content')
    <div class="container">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.users.index') }}">&larr; Back to
            Users</a>
        <div class="row card mb-3">

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

        {{-- Edit and delete buttons --}}
        <div class="container d-flex justify-content-center align-items-center gap-2">
            <a type="button" class="btn btn-warning" href="{{ route('admin.users.edit', $user) }}">Edit</a>
            <form class="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>

    </div>
@endsection
