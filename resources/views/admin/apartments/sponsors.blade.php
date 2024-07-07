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
            <form action="{{ route('admin.apartments.new_sponsor') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Input nascosti --}}
                <input type="hidden" name="selected_apartment" id="selected_apartment" value="">
                <input type="hidden" name="apartment_sponsor_expiration" id="apartment_sponsor_expiration" value="">
                <input type="hidden" name="sponsor_hours" id="sponsor_hours" value="">

                {{-- Apartment selection --}}
                <div class="col-auto">
                    <h3 class="text-center mb-5">Select an apartment</h3>
                    <div class="row justify-content-start align-items-center px-3">
                        @foreach ($apartments as $apartment)
                            <div class="col-4 mb-4 px-3 apartment-col" data-apartment-id="{{ $apartment->id }}"
                                data-apartment-sponsor-expiration="{{ $apartment->sponsor_expiration }}"
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
                <div class="col-auto mb-3">
                    <h3 class="text-center mb-5">Select a sponsor tier</h3>
                    <div class="row justify-content-center align-items-center">
                        @foreach ($sponsors as $sponsor)
                            <div class="col-auto">
                                <label for="sponsor-{{ $sponsor->id }}">
                                    <strong class="text-center w-100 d-inline-block">{{ $sponsor->tier }}</strong>
                                    <p>{{ $sponsor->hours }} hours for {{ $sponsor->price }}$</p>
                                </label>
                                <input type="radio" name="selected_sponsor" id="sponsor-{{ $sponsor->id }}"
                                    value="{{ $sponsor->id }}" data-sponsor-hours="{{ $sponsor->hours }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-auto text-center mb-5">
                    <h3>Placeholder pagamento</h3>
                </div>

                <div class="col-auto text-center mb-3">
                    <button class="btn btn-warning">Submit</button>
                </div>

            </form>
        </div>

    </div>

    <style>
        .apartment-col.selected .card-header {
            background-color: #FFB440;
        }

        .apartment-col.selected .card-body {
            background-color: #F7851D
        }
    </style>

    <script>
        function selectApartment(element) {
            // Rimuovi la classe selected a tutti gli appartamenti
            let apartmentCols = document.querySelectorAll('.apartment-col');
            apartmentCols.forEach(function(apartmentCol) {
                apartmentCol.classList.remove('selected');
            });

            // Aggiungi la classe a quello cliccato
            element.classList.add('selected');

            // Assegna il valore all'hidden dell'appartamento
            let apartmentId = element.getAttribute('data-apartment-id');
            document.getElementById('selected_apartment').value = apartmentId;

            // Assegna il valore all'hidden dello scadere dello sponsor
            let apartmentSponsorExpiration = element.getAttribute('data-apartment-sponsor-expiration');
            document.getElementById('apartment_sponsor_expiration').value = apartmentSponsorExpiration;
        }

        //Qui ascolti se viene cambiato l'input hidden dello sponsor, e se viene cambiato prende le sue ore
        document.querySelectorAll('input[name="selected_sponsor"]').forEach(function(input) {
            input.addEventListener('change', function() {
                let sponsorHours = this.getAttribute('data-sponsor-hours');
                document.getElementById('sponsor_hours').value = sponsorHours;
            });
        });
    </script>
@endsection
