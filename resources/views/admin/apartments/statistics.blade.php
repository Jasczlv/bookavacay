@extends('layouts.app')

@section('content')
    <section id="full-page-section">
        @if ($apartment->user_id === Auth::id())
            <div class="container py-5">
                <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back
                    to Apartments</a>
                <div class="row">
                    <h2 class="text-center">{{ $apartment->title }} statistics</h2>
                </div>

                <div class="row justify-content-between align-items-center">
                    <div class="col-md-8">
                        <div style="width: 800px;"><canvas id="acquisitions"></canvas></div>
                        <div style="width:75%;">
                            {!! $chartjs->render() !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h4>Statistics Summary</h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Total views</th>
                                    <td>{{ count($statistics) }}</td>
                                </tr>
                                <tr>
                                    <th>Month with the highest views</th>
                                    <td>{{ $highestMonth }}</td>
                                </tr>
                                <tr>
                                    <th>Month with the lowest views</th>
                                    <td>{{ $lowestMonth }}</td>
                                </tr>
                                <tr>
                                    <th>Ranking in 30km radius</th>
                                    <td>{{ $ranking }}#</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="container py-5">
                <h3 class="text-center">
                    You don't have access to this page
                </h3>
            </div>
        @endif
    </section>
@endsection
