@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestisci i tuoi post</h1>

        <div class="row">
            @foreach ($posts as $post)

                <div class="col-4">

                    <div class="card" style="width: 18rem;">
                        
                        <div class="card-body">

                            <h5 class="card-title">{{ ucfirst($post->title) }}</h5>
                            
                            <a href="{{route('admin.posts.show', ['post' =>$post->id] )}}" class="btn btn-primary">Vai al post</a>

                            <a href="{{route('admin.posts.edit', ['post' =>$post->id] )}}" class="btn btn-primary">Modifica post</a>  
                            
                            <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}"  method="post">
                                @csrf
                                @method('DELETE')

                                <input type="submit" class="btn btn-secondary" value="Cancella post">

                            </form>

                        </div>
                    </div>

                </div>
                
            @endforeach
            
        </div>

        
    </div>
    
    </div>
@endsection