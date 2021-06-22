<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Antipasti', 'Primi', 'Secondi', 'Contorni', 'Dolci'
        ];

        foreach($categories as $category_name) {

            $new_category = new Category();
            $new_category->name = $category_name;
            $new_category->slug = Str::slug($new_category->title, '-');
            $new_category->save();
        }
    }
}
