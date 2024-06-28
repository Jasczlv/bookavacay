@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <h2>{{ $sponsor->tier }}</h2>
        <h3>Hours: {{ $sponsor->hours }}</h3>
        <h3>Price: {{ $sponsor->price }}</h3>
    </div>
</section>

@endsection
