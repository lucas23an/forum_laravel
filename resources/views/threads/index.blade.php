@extends('layouts.default')

@section('content')

    <div class="container">
        <h3>{{ __('Most recent threads') }}</h3>
        <threads title="{{ __('threads') }}">
            @include('layouts.default.preloader')
        </threads>
    </div>
@endsection

@section('scripts')
    <script src="/js/threads.js"></script>
@endsection