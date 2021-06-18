<?php

use Illuminate\Database\Seeder;
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 5; $i++){
            $newPost = new Post();
            $newPost->title = $faker->words(4, true);
            $newPost->content = $faker->paragraphs(4, true);
            $newPost->slug = Str::slug($newPost->title, '-');
            $newPost->save();
        } 
    }
}
