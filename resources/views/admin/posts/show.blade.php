@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ ucfirst($post->title) }}</h1>

        <p>Slug: {{ $post->slug }}</p>

        <p>{{ ucfirst($post->content) }}</p>

        
    </div>
    
@endsection