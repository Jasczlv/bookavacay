@extends('layouts.app')

@section('content')
    <h1>Services</h1>
    <a href="{{route('admin.services.create')}}">create</a>
    {{-- <a href="{{route('admin.services.show')}}">Show</a> --}}
    @foreach ($services as $service)
        <a href="{{route('admin.services.show', $service->id)}}"><p>{{$service->name}}</p></a>
    @endforeach
@endsection

