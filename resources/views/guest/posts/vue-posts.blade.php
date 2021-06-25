@extends('layouts.app')


@section('header-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>    
@endsection

@section('footer-script')
    <script src="{{ asset('js/posts.js') }}"></script>    
@endsection




@section('content')

    <div class="container">

        <div id="root">

            <h1>@{{ title }}</h1>

            <div class="row">

                <div v-for="post in posts" class="col-4">

                    <div class="card" style="width: 18rem;">
                        
                        <div class="card-body">
                            
                          <h5 class="card-title">@{{ post.title }}</h5>

                          <p>@{{ post.content.substring(0, 100)}}...</p>
                          
                          

                        </div>
                    </div>

                </div>
            

            </div>
        
            
        </div>
    </div>
    
@endsection