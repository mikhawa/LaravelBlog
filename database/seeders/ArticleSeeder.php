<?php

namespace Database\Seeders;

use App\Models\Article;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // utilisation de faker https://github.com/fzaninotto/Faker
        $faker = Factory::create();

        for ($i = 0; $i < 26; $i++) {

            Article::create([
                'title' => $faker->sentence(),
                'subtitle' => $faker->sentence(),
                'content' => $faker->text(600),
            ]);
        }
    }
}
