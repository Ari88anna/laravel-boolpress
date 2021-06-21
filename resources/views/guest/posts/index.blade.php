@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Leggi le ultime news</h1>

        <div class="row">
            @foreach ($posts as $post)

                <div class="col-4">

                    <div class="card" style="width: 18rem;">
                        
                        <div class="card-body">
                            
                          <h5 class="card-title">{{ ucfirst($post->title) }}</h5>

                          <p>{{ Str::words($post->content, 20) }}</p>
                          
                          <a href="{{ route('blog-page', ['slug'=>$post->slug]) }}" class="btn btn-primary">Leggi il post</a>

                        </div>
                    </div>

                </div>
                
            @endforeach
            
        </div>
    </div>
    
@endsection