<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $postIds = DB::table('posts')->pluck('id');
        foreach ($postIds as $postId) {
            $commentCount = rand(1, 50);
            foreach (range(1, $commentCount) as $comment) {
                Comment::upsert([
                    'post_id' => $postId,
                    'name' => $faker->name,
                    'text' => $faker->text,
                ], ['name']);
            }
        }
    }
}
