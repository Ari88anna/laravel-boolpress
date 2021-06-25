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
            

        </div>
        
            
        </div>
    </div>
    
@endsection