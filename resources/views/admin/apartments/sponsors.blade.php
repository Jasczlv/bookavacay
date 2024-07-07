@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back to
            Apartments</a>

        <div class="card">
            <div class="card-header text-center mb-3">
                <h2>Sponsor an Apartment</h2>
            </div>

            {{-- Inizio form --}}
            <form id="payment-form" action="{{ route('admin.apartments.new_sponsor') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Input nascosti --}}
                <input type="hidden" name="selected_apartment" id="selected_apartment" value="">
                <input type="hidden" name="apartment_sponsor_expiration" id="apartment_sponsor_expiration" value="">
                <input type="hidden" name="sponsor_hours" id="sponsor_hours" value="">

                {{-- Selezione dell'appartamento --}}
                <div class="col-auto">
                    <h3 class="text-center mb-5">Select an Apartment</h3>
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
                                            <p>Sponsor expires: {{ $apartment->sponsor_expiration }}</p>
                                        @else
                                            <p>No active sponsor found.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Selezione dello sponsor --}}
                <div class="col-auto mb-3">
                    <h3 class="text-center mb-5">Select a sponsor tier</h3>
                    <div class="row justify-content-center align-items-center">
                        @foreach ($sponsors as $sponsor)
                            <div class="col-auto">
                                <label for="sponsor-{{ $sponsor->id }}">
                                    <strong class="text-center w-100 d-inline-block">{{ $sponsor->tier }}</strong>
                                    <p>{{ $sponsor->hours }} ore per {{ $sponsor->price }}€</p>
                                </label>
                                <input type="radio" name="selected_sponsor" id="sponsor-{{ $sponsor->id }}"
                                    value="{{ $sponsor->id }}" data-sponsor-hours="{{ $sponsor->hours }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pagamento --}}
                <div class="col-auto text-center mb-5">
                    <h3>Payment</h3>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div id="dropin-container"></div>
                        </div>
                    </div>

                    {{-- Pulsante di pagamento --}}
                    <div class="col-auto text-center mb-3">
                        <button id="payment-btn" class="btn btn-primary">Pay Now</button>
                    </div>
                </div>

                <div class="col-auto text-center mb-3">
                    <button id="submit-btn" class="btn btn-warning"
                        @if (!isset($paymentSuccessful) || !$paymentSuccessful) disabled @endif>Submit</button>
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
            // Rimuovi la classe selected da tutti gli appartamenti
            let apartmentCols = document.querySelectorAll('.apartment-col');
            apartmentCols.forEach(function(apartmentCol) {
                apartmentCol.classList.remove('selected');
            });

            // Aggiungi la classe a quello cliccato
            element.classList.add('selected');

            // Assegna il valore all'input nascosto dell'appartamento
            let apartmentId = element.getAttribute('data-apartment-id');
            document.getElementById('selected_apartment').value = apartmentId;

            // Assegna il valore all'input nascosto della scadenza dello sponsor
            let apartmentSponsorExpiration = element.getAttribute('data-apartment-sponsor-expiration');
            document.getElementById('apartment_sponsor_expiration').value = apartmentSponsorExpiration;
        }

        // Ascolta il cambio dell'input nascosto dello sponsor selezionato
        document.querySelectorAll('input[name="selected_sponsor"]').forEach(function(input) {
            input.addEventListener('change', function() {
                let sponsorHours = this.getAttribute('data-sponsor-hours');
                document.getElementById('sponsor_hours').value = sponsorHours;

                // Abilita/disabilita il pulsante di invio in base alla selezione del metodo di pagamento
                let submitBtn = document.getElementById('submit-btn');
                submitBtn.disabled = !isPaymentMethodSelected();
            });
        });

        // Inizializzazione di Braintree Drop-in
        let clientToken = "{{ session('clientToken') }}"; // Recupera il token del client dalla sessione

        braintree.dropin.create({
            authorization: clientToken,
            container: '#dropin-container'
        }, function(createErr, instance) {
            if (createErr) {
                console.error('Errore nella creazione di Drop-in:', createErr);
                return;
            }

            let paymentForm = document.querySelector('#payment-form');
            let paymentBtn = document.getElementById('payment-btn');
            let submitBtn = document.getElementById('submit-btn');

            // Funzione per verificare se il nonce del metodo di pagamento è presente, non ho capito bene cosa sia
            function isPaymentMethodSelected() {
                let paymentMethodNonce = document.getElementById('payment_method_nonce').value;
                return !!paymentMethodNonce; // Restituisce true se il nonce esiste
            }

            // Event listener per il clic sul pulsante di pagamento
            paymentBtn.addEventListener('click', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
                    if (requestPaymentMethodErr) {
                        console.error('Errore nella richiesta del metodo di pagamento:',
                            requestPaymentMethodErr);
                        return;
                    }

                    // Opzionalmente, mostra un messaggio di successo
                    console.log('Nonce del metodo di pagamento:', payload.nonce);
                    alert('Pagamento effettuato con successo!'); // Alert opzionale per il test

                    // Abilita il pulsante di invio dopo il pagamento riuscito
                    submitBtn.disabled = false;

                    // Aggiorna l'input nascosto del nonce nel form
                    document.getElementById('payment_method_nonce').value = payload.nonce;
                });
            });

            // Event listener per il submit del form
            paymentForm.addEventListener('submit', function(event) {
                // Verifica se il nonce del metodo di pagamento è presente prima di consentire l'invio del form
                if (!isPaymentMethodSelected()) {
                    event.preventDefault();
                    alert('Completa prima il pagamento.');
                }
            });

            // Disabilita il submit del form inizialmente
            submitBtn.disabled = true;

            // Ascolta i cambiamenti nel form di Braintree drop-in
            document.getElementById('dropin-container').addEventListener('change', function(event) {
                // Abilita/disabilita il pulsante di invio in base alla selezione del metodo di pagamento
                submitBtn.disabled = !isPaymentMethodSelected();
            });
        });
    </script>
@endsection
