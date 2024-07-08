@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back to
            Apartments</a>
        <div class="row">
            <p>Placeholder statistics</p>
            <div class="col-auto">
                {{ count($statistics) }}
            </div>
        </div>

        <div style="width: 800px;"><canvas id="acquisitions"></canvas></div>


        <div style="width:75%;">
            {!! $chartjs->render() !!}
        </div>


    </div>
@endsection
