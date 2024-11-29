<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 1000) as $authorId) {
            $postCount = rand(100, 500);
            foreach (range(1, $postCount) as $post) {
                Post::upsert([
                    'title' => $faker->sentence,
                    'author_id' => $authorId,
                ],['title']);
            }
        }
    }
}
