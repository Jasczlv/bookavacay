@extends('layouts.app')

@section('content')
    <div class="general-div-services">
        <h1>Services</h1>
        <a href="{{ route('admin.services.create') }}">create</a>
        {{-- <a href="{{route('admin.services.show')}}">Show</a> --}}
        <div class="container-services">
            <div class="row-services">

                @foreach ($services as $service)
                    <div class="card-services">
                        <a href="{{ route('admin.services.show', $service->id) }}">
                            <p>{{ $service->name }}</p>
                        </a>
                        <a href="{{ route('admin.services.edit', $service->id) }}">Edit</a>
                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
