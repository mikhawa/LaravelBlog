@extends('base')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3">
    <h1 class="display-4 text-center">{{ $article->title }} </h1>
    <div class="d-flex justify-content-center my-5">
        <a class="btn btn-primary" href="{{ route('articles') }}">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
    <h4 class="text-center my-2 pt-2">{{ $article->subtitle }}</h5>
</div>
    <div class="container">
        <p class="text-justify">{{ $article->content }}</p>
    </div>
@endsection