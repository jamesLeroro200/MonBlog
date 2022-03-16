<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Categories;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::withoutEvents(function (){
            //Create 1 admin
            User::factory(1)->create([
                'role' => 'admin',
            ]);

            //Create 2 redactors
            User::factory(2)->create([
                'role' => 'redac',
            ]);

            //Create 3 simple users
            User::factory(3)->create();
        });

        $nbrUsers = 6;

        //Create 3 categories
        DB::table('categories')->insert([
            [
                'title' => 'Category 1',
                'slug' => 'category-1'
            ],
            [
                'title' => 'Category 2',
                'slug' => 'category-2'
            ],
            [
                'title' => 'Category 3',
                'slug' => 'category-3'
            ],
        ]);

        $nbrCategories = 3;

        //Create 6 tags
        DB::table('tags')->insert([
            ['title' => 'Tag1', 'slug' => 'tag1'],
            ['title' => 'Tag2', 'slug' => 'tag2'],
            ['title' => 'Tag3', 'slug' => 'tag3'],
            ['title' => 'Tag4', 'slug' => 'tag4'],
            ['title' => 'Tag5', 'slug' => 'tag5'],
            ['title' => 'Tag6', 'slug' => 'tag6'],
        ]);

        $nbrTags = 6;

        //Create 9 articles attributed to 2 redactors
        Article::withoutEvents(function (){
            foreach (range(1,2) as $item){
                Article::factory()->create([
                    'title' => 'Article '.$item,
                    'slug' => 'article-'.$item,
                    'seo_title' => 'Article '.$item,
                    'user_id' => 2,
                    'images' => 'img0'.$item.'.jpg',
                ]);
            }

            foreach (range(3,9) as $item){
                Article::factory([
                    'title' => 'Article '.$item,
                    'slug' => 'article-'.$item,
                    'seo_title' => 'Article '.$item,
                    'user_id' => 3,
                    'images' => 'img0'.$item.'.jpg',
                ]);
            }
        });

        $nbrArticles = 9;


        //Tags attach to Articles
        $articles = Article::all();

        foreach ($articles as $article){
            if($article->id === 9)
            {
                $numbers = [1,2,5,6];
                $n = 4;
            }
            else
            {
                $numbers = range(1, $nbrTags);
                shuffle($numbers);
                $n = rand(2, 4);
            }

            for($i=0; $i<$n; ++$i){
                $article->tags()->attach($numbers[$i]);
            }
        }

        //Set Categories
        foreach ($articles as $article){
            if ($article->id === 9)
            {
                DB::table('article_categories')->insert([
                    'categories_id' => 1,
                    'article_id' => 9,
                ]);
            }
            else
            {
                $numbers = range (1, $nbrCategories);
                shuffle ($numbers);
                $n = rand (1, 2);
                for ($i = 0; $i < $n; ++$i){
                    DB::table('article_categories')->insert([
                        'categories_id' => $numbers[$i],
                        'article_id' => $article->id,
                    ]);
                }
            }
        }

        //Create Parents Comments
//        foreach (range(1, $nbrArticles - 1) as $i) {
//            Comment::factory()->create([
//                'article_id' => $i,
//                'user_id' => rand(1, $nbrUsers),
//            ]);
//        }
//
//        $faker = \Faker\Factory::create();
//        Comment::create([
//            'article_id' => 2,
//            'user_id' => 3,
//            'body' => $faker->paragraph(4, true),
//            'children' => [
//                    'article_id' => 2,
//                    'user_id' => 4,
//                    'body' => $faker->paragraph(4, true),
//                    'children' => [
//                        [
//                            'article_id' => 2,
//                            'user_id' => 2,
//                            'body' => $faker->paragraph(4, true),
//                        ],
//                    ],
//                ],
//        ]);

//        Comment::create([
//            'article_id' => 2,
//            'user_id' => 6,
//            'body' => $faker->paragraph(4, true),
//            'children' => [
//                [
//                    'article_id' => 2,
//                    'user_id' => 3,
//                    'body' => $faker->paragraph(4, true),
//                ],
//                [
//                    'article_id' => 2,
//                    'user_id' => 6,
//                    'body' => $faker->paragraph(4, true),
//                    'children' => [
//                        [
//                            'article_id' => 2,
//                            'user_id' => 3,
//                            'body' => $faker->paragraph(4, true),
//
//                            'children' => [
//                                [
//                                    'article_id' => 2,
//                                    'user_id' => 6,
//                                    'body' => $faker->paragraph(4, true),
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ]);
//        Comment::create([
//            'article_id' => 4,
//            'user_id' => 4,
//            'body' => $faker->paragraph(4, true),
//            'children' => [
//                [
//                    'article_id' => 4,
//                    'user_id' => 5,
//                    'body' => $faker->paragraph(4, true),
//                    'children' => [
//                        [   'article_id' => 4,
//                            'user_id' => 2,
//                            'body' => $faker->paragraph(4, true),
//                        ],
//                        [
//                            'article_id' => 4,
//                            'user_id' => 1,
//                            'body' => $faker->paragraph(4, true),
//                        ],
//                    ],
//                ],
//            ],
//        ]);

    }
}
