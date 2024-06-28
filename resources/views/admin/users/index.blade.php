@extends('layouts.app')

@section('content')
    @foreach ($users as $user)
        <div class="container">
            <label for="user" class="fw-bold">User ID {{ $user->id }}</label>
            <div class="d-flex justify-content-between">
                <p name="user" id="user">{{ $user->email }}</p>
                <div class="d-flex gap-3">

                    <a class="btn btn-primary" href="{{ route('admin.users.show', $user->id) }}">Show</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        <button class="btn btn-danger">Trash</button>

                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
