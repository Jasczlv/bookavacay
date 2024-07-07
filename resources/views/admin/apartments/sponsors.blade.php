@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back to
            Apartments</a>

        <div class="card">
            <div class="card-header text-center mb-3">
                <h2>Sponsor Apartment</h2>
            </div>

            {{-- Inizio form --}}
            <form action="">

                {{-- Input hidden di appartamento --}}
                <input type="hidden" name="selected_apartment" id="selected_apartment" value="">

                {{-- Apartment selection --}}
                <div class="col-auto">
                    <h3 class="text-center mb-5">Select an apartment</h3>
                    <div class="row justify-content-start align-items-center">
                        @foreach ($apartments as $apartment)
                            <div class="col-4 mb-4 px-3 apartment-col" data-apartment-id="{{ $apartment->id }}"
                                onclick="selectApartment(this)">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h4>{{ $apartment->title }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <img class="mw-100"
                                                src="{{ Vite::asset('storage/app/public/images/' . $apartment->image) }}"
                                                alt="">
                                        </div>
                                        @if ($apartment->sponsor_expiration)
                                            <p>Sponsor Expiration Date: {{ $apartment->sponsor_expiration }}</p>
                                        @else
                                            <p>No active sponsor found for this apartment.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Sponsor selection --}}
                <div class="col-auto">
                    <h3 class="text-center mb-5">Select a sponsor tier</h3>
                    <div class="row justify-content-center align-items-center">
                        @foreach ($sponsors as $sponsor)
                            <div class="col-auto">
                                <label for="sponsor-{{ $sponsor->id }}">
                                    <strong class="text-center w-100 d-inline-block">{{ $sponsor->tier }}</strong>
                                    <p>{{ $sponsor->hours }} hours for {{ $sponsor->price }}$</p>
                                </label>
                                <input type="radio" name="selected_sponsor" id="sponsor-{{ $sponsor->id }}">
                            </div>
                        @endforeach
                    </div>
                </div>

            </form>
        </div>

    </div>

    <style>
        .apartment-col.selected {
            background-color: #cce5ff;
        }
    </style>

    <script>
        function selectApartment(element) {
            //quando parte la funzione recupera tutti gli .apartment-col e togligli la classe selected
            let apartmentCols = document.querySelectorAll('.apartment-col');
            apartmentCols.forEach(function(apartmentCol) {
                apartmentCol.classList.remove('selected');
            });

            //aggiungi la classe selected a quello cliccato
            element.classList.add('selected');

            // metti il valore di data-apartment-id all'input nascosto
            let apartmentId = element.getAttribute('data-apartment-id');
            document.getElementById('selected_apartment').value = apartmentId;
        }
    </script>
@endsection
