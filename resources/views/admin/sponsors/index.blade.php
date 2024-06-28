@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <h1 class="mt-4">Sponsors</h1>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tier</th>
                    <th>Hours</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sponsors as $sponsor)
                    <tr>
                        <th>{{ $sponsor->id }}</th>
                        <th>{{ $sponsor->tier }}</th>
                        <th>{{ $sponsor->hours }}</th>
                        <th>{{ $sponsor->price }}</th>
                        <th>
                            <a href="{{ route('admin.sponsors.edit',$sponsor) }}">Edit</a>
                        </th>
                        <th>
                            <form class="delete-form" action="{{ route('admin.sponsors.destroy',$sponsor) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="ml-2 text-danger">Delete</button>
                            </form>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container">
        <button class="card mb-3 p-2">
            <a href="{{ route('admin.sponsors.create') }}">Add a new sponsor</a>
        </button>
    </div>
</section>

@endsection
