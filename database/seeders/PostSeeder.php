<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::factory(100)->create();
        foreach ($posts as $post) {
            Image::factory(1)->create([
                'imageable_id' => $post->id,
                'imageable_type'=>Post::class
            ]);
            
            //agregar un nuevo registro en la tabla post_tag, en campo post_tag pone de 1 a 4 y de 5 a 8
            //agrega dos etiquetas a cada post
            $post->tags()->attach([
                rand(1,4),
                rand(5,8)
            ]);
        }
    }
}
