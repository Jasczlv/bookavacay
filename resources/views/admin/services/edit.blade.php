@extends('layouts.app')

@section('content')
    <form action="{{route('admin.services.update', $service)}}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{$service->name}}">
        <button>Sent</button>
    </form>

    @if($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection