@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <h1>Sponsors</h1>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
