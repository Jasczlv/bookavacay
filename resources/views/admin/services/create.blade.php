@extends('layouts.app')

@section('content')
    <form action="{{route('admin.services.store')}}" method="POST">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <button>Invia</button>
    </form>


@endsection