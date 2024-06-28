@extends('layouts.app')

@section('content')
    <h1>Services</h1>
    <p>{{$service->name}}</p>
    <a href="{{route('admin.services.index')}}">back</a>
@endsection

