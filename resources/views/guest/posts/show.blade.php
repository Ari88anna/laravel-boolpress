@extends('layouts.app')

@section('content')
    <div class="container">

        @if($post_category)

            <div>Categoria: {{ $post_category->name }}</div>

        @endif

        <h1>{{ ucfirst($post->title) }}</h1>

        

        <p>{{ ucfirst($post->content) }}</p>

        
    </div>
    
@endsection