@extends('layouts.app')

@section('content')
    {{-- TITOLO E CREATE --}}
    <div class="container">
        <h1 class="mt-4">Users</h1>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a type="button" class="btn btn-primary mt-2 mb-3" href="{{ route('admin.users.create') }}">Add a new user</a>

            {{-- Users search input --}}
            <form action="{{ route('admin.users.search') }}" method="GET">
                @csrf
                <div class="input-group">
                    <input type="text" name="query" class="form-control mx-2 rounded" placeholder="Search users">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
    </div>


    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mail</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <a class="btn-link" href="{{ route('admin.users.show', $user) }}">{{ $user->email }}</a>
                        </td>

                        {{-- EDIT --}}
                        <td>
                            <a type="button" class="btn btn-warning" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                        </td>
                        {{-- DELETE --}}
                        <td>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#user{{ $user->id }}">
                                Delete
                            </button>
                            {{-- MODAL --}}
                            <div class="modal fade" id="user{{ $user->id }}"
                                aria-labelledby="userLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="userLabel{{ $user->id }}">Delete user</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure to delete this user?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button class="btn btn-link link-danger">Delete</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
