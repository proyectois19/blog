<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:admin.posts.index')->only('index');
        $this->middleware('can:admin.posts.create')->only('create','store');
        $this->middleware('can:admin.posts.edit')->only('edit','update');
        $this->middleware('can:admin.posts.destroy')->only('destroy');
        
    }

    public function index()
    {
        return view('admin.posts.index');
    }

    
    public function create()
    {   
        $categories = Category::pluck('name','id');
        $tags = Tag::all();
        return view('admin.posts.create',compact('categories','tags'));
    }

    public function store(PostRequest $request)
    {
        
        //return $request->file('file');
        //return $request->all();
        $post = Post::create($request->all());
        if($request->file('file')) {
            // Mueve el archivo de la direccion temporal al Storage y almacena la url en una variable
            $url = Storage::put('public/posts',$request->file('file'));

            //accedo a la realcion y le paso el metodo create, despues los campos con la que quiero crear
            $post->image()->create([
                // va a tomar en imageable_id y imageable_type de $post
                //ademas hay que habilitar la asignacion masiva
                'url'=> $url
            ]);
        } 

        //vemos si hay info de etiquetas
        if ($request->tags) {
            //accedo a la relacion muchos a muchos
            //llamo al metodo attach y accedemos al array tags
            $post->tags()->attach($request->tags);
        }
        
        //Eliminamos el cache 
        Cache::flush();
        return redirect()->route('admin.posts.edit',$post);
    }

    public function edit(Post $post)
    {   
        //policy de autenticacion
        $this->authorize('author', $post);

        $categories = Category::pluck('name','id');
        $tags = Tag::all();
        return view('admin.posts.edit',compact('post','categories','tags'));
    }

    public function update(PostRequest $request, Post $post)
    {
        //policy de autenticacion
        $this->authorize('author', $post);

        $post->update($request->all());
        if ($request->file('file')) {
            //almace en una carpeta post 
            $url = Storage::put('public/posts',$request->file('file'));

            // preguntamos si el post tenia una imagen 
            if ($post->image) {
                //lo eliminamos
                Storage::delete($post->image->url);
                $post->image->update([
                    'url'=>$url
                ]);
            }else{
                $post->image()->create([
                    'url'=>$url
                ]);
            }
        }

        if ($request->tags) {
            //sincrozamos las etiquetas
            $post->tags()->sync($request->tags);
        }
        Cache::flush();
        return redirect()->route('admin.posts.edit',$post)->with('info','El post se actualizo con exito');
    }

    public function destroy(Post $post)
    {
        //policy de autenticacion
        $this->authorize('author', $post);

        $post->delete();
        Cache::flush();
        return redirect()->route('admin.posts.index')->with('info','El post se elimino con exito');
    }
}
