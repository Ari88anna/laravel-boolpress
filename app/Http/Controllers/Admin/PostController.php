<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        $data = [
            'posts'=> $posts
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validazione

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max: 65000'
        ]);

        $new_post_data = $request->all();
       

        // Gestione slug
        $new_slug = Str::slug($new_post_data['title'], '-');
        
        $base_slug = $new_slug;
        //Controlliamo che non esista un post con questo slug
        $post_with_existing_slug = Post::where('slug', '=', $new_slug)->first();
        $counter = 1;

        //Se esiste tento con altri slug
        while($post_with_existing_slug) {
            //Provo un nuovo slug appendendo il counter
            $new_slug = $base_slug . '-' . $counter ; 
            $counter++ ;

            //Se anche il nuovo slug esiste nel database, il ciclo while continua
            $post_with_existing_slug = Post::where('slug', '=', $new_slug)->first();
        }

        //Quando troviamo uno slug libero, popoliamo i data da salvare
        $new_post_data['slug'] = $new_slug;

        $new_post = new Post();
        $new_post -> fill($new_post_data);        
        $new_post -> save();

        return redirect()->route('admin.posts.show', ['post' => $new_post->id]);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $data = [
            'post'=>$post
        ];

        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
