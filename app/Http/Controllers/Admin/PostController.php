<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostNotification;
use App\Category;
use App\Post;
use App\Tag;

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
        $categories = Category::all();
        $tags = Tag::all();        

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];


        return view('admin.posts.create', $data);
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
            'content' => 'required|max: 65000',
            'category_id'=> 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'cover-image' => 'nullable|image'
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

        //Se c'è un'img caricata dall'utente la salvo in storage 
        //e aggiungo il path relativo a cover in $new_post_data  

        if(isset($new_post_data['cover-image'])) {
            //put()ha bisogno di 2 argomenti: 1-la sottocartella in cui salvare il file 2-il file da salvare
            $new_img_path = Storage::put('posts-cover', $new_post_data['cover-image'] );
            
            if ($new_img_path) {
                $new_post_data['cover'] = $new_img_path;
            }
                        
        }

        $new_post = new Post();
        $new_post -> fill($new_post_data);        
        $new_post -> save();

        if(isset($new_post_data['tags']) && is_array($new_post_data['tags'])) {
            $new_post ->tags()->sync($new_post_data['tags']);
        }

        //Invio email

        Mail::to('arianna@gmail.com')->send(new NewPostNotification($new_post));

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
            'post'=>$post,
            'post_category' => $post->category ,
            'post_tags' => $post->tags          
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
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.edit', $data);
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

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max: 65000',
            'category_id'=> 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'cover-image' => 'nullable|image'
        ]);

       $edit_post_data = $request->all();

       $post = Post::findOrFail($id);
        //Di default lo slug non dovrebbe essere cambiato a meno che cambi il titolo del post
       $edit_post_data['slug'] = $post->slug; 


        //Ricalcolo il nuovo slug solo se il  titolo del post nuovo è diverso da quello precedente
        if($edit_post_data['title'] != $post->title) {
           // Gestione slug
            $new_slug = Str::slug($edit_post_data['title'], '-');
                
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
            $edit_post_data['slug'] = $new_slug;
        }

        if(isset($edit_post_data['cover-image'])) {
            //put()ha bisogno di 2 argomenti: 1-la sottocartella in cui salvare il file 2-il file da salvare
            $img_path = Storage::put('posts-cover', $edit_post_data['cover-image'] );
            
            if ($img_path) {
                $edit_post_data['cover'] = $img_path;
            }                        
        }       
       
       $post->update($edit_post_data);

        //Tags
        if(isset($edit_post_data['tags']) && is_array($edit_post_data['tags'])) {
            $post->tags()->sync($edit_post_data['tags']);
        } else {
            $post->tags()->sync([]);
        }       

        return redirect()->route('admin.posts.show', ['post' => $post->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // prima di cancellare il post svuoto le relazioni con la tabella ponte
        $post -> tags()->sync([]);

        $post -> delete();

        

        return redirect()->route('admin.posts.index');
    }
}
