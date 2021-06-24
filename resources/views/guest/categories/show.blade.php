@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $category->name }}</h1>

        <ul>

            @foreach($related_post as $post)

                <li>
                    <a href="{{ route('blog-page', ['slug' =>$post->slug]) }}">{{ $post->title }}</a>
                </li>
                
            @endforeach

        </ul>
    </div>
    
@endsection