@extends('layouts.app')

@section('content')
    <div class="container">

        @if($post_category)
            <p>Categoria: {{ $post_category->name }}</p>
        @endif

        <div>
            <span>Tag:</span>
            @foreach ($post_tags as $tag)

                {{ $tag->name }} {{$loop->last ? '' : ','}}
            
            @endforeach
        </div>

        <h1>{{ ucfirst($post->title) }}</h1>

        <p>Slug: {{ $post->slug }}</p>

        @if($post->cover)

            <img src="{{  asset('storage/'. $post->cover) }}" alt="{{ $post->title }}">

        @endif
        

        <p>{{ ucfirst($post->content) }}</p>

        <div>
            <a href="{{ route('admin.posts.edit', ['post'=>$post->id] ) }}">Modifica post</a>
        </div>

        
    </div>
    
@endsection