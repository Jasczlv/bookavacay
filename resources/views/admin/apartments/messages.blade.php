@extends('layouts.app')

@section('content')
    <section id="full-page-section">
        @if ($apartment->user_id === Auth::id())
            <div class="container py-5">
                <a type="button" class="btn btn-secondary mt-4 mb-3" href="{{ route('admin.apartments.index') }}">&larr; Back
                    to Apartments</a>
                <div class="row flex-column justify-content-center align-items-center py-3">
                    <h2 class="text-center mb-5">Messages sent to {{ $apartment->title }}</h2>
                    @foreach ($notifications as $notification)
                        <div class="col-12 mb-5">
                            <div class="card">
                                <div class="card-header highlight-header">
                                    <p>Sent by <span class="text-warning">
                                            <a
                                                href="mailto:{{ $notification->sender_email }}?subject={{ $apartment->title }}">{{ $notification->sender_email }}</a>
                                        </span> on {{ $notification->formatted_date }} at
                                        {{ $notification->formatted_time }}</p>
                                </div>
                                <div class="card-body highlight-body">
                                    {{ $notification->content }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($messages as $message)
                        <div class="col-12 mb-5">
                            <div class="card">
                                <div class="card-header {{ $message->notification ? 'highlight-header' : '' }}">
                                    <p>Sent by <span class="text-warning">
                                            <a
                                                href="mailto:{{ $message->sender_email }}?subject={{ $apartment->title }}">{{ $message->sender_email }}</a>
                                        </span> on {{ $message->formatted_date }} at {{ $message->formatted_time }}</p>
                                </div>
                                <div class="card-body {{ $message->notification ? 'highlight-body' : '' }}">
                                    {{ $message->content }}
                                </div>
                            </div>
                        </div>
                    @endforeach
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


<style scoped>
    .highlight-header {
        background-color: #F7851D !important;
    }

    .highlight-body {
        background-color: #FFB440 !important;
        color: black !important;
    }
</style>
