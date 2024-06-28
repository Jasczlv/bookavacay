@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Rooms</th>
                    <th>Beds</th>
                    <th>Bathrooms</th>
                    <th>Sqr mt.</th>
                    <th>Address</th>
                    <th>Lat</th>
                    <th>Lon</th>
                    <th>Visible</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>
                        <td>{{ $apartment->id }}</td>
                        <td>{{ $apartment->title }}</td>
                        <td>{{ $apartment->rooms }}</td>
                        <td>{{ $apartment->beds }}</td>
                        <td>{{ $apartment->bathrooms }}</td>
                        <td>{{ $apartment->sqr_mt }}</td>
                        <td>{{ $apartment->address }}</td>
                        <td>{{ $apartment->lat }}</td>
                        <td>{{ $apartment->lon }}</td>
                        <td>{{ $apartment->visible }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
