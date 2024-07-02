@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back to
            Apartments</a>
        <div class="row card">
            <p>Placeholder sponsors</p>
            @php
                dd($apartments, $sponsors);
            @endphp
        </div>
    </div>
@endsection
