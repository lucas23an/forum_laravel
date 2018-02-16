@extends('layouts.default')

@section('content')

    <div class="container">
        <h3>{{ $result->title }}</h3>

        <div class="card grey light-4">
            <div class="card-content">
                {{ $result->body }}
            </div>
        </div>

        <replies></replies>
    </div>
@endsection

@section('scripts')
    <script src="/js/replies.js"></script>
@endsection