@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tutte le categorie</h1>

        <div class="row">
            @foreach ($categories as $category)

                <div class="col-4">

                    <div class="card" style="width: 18rem;">
                        
                        <div class="card-body">
                            
                            <h5 class="card-title">{{ $category->name }}</h5>
                            
                          
                            <a href="{{ route('category-page', ['slug' => $category->slug]) }}" class="btn btn-primary">Guarda tutte le ricette</a>

                        </div>
                    </div>

                </div>
                
            @endforeach
            
        </div>
    </div>
    
@endsection