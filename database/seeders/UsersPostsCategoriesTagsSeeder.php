<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersPostsCategoriesTagsSeeder extends Seeder
{
    /**
     * Seed users, posts, categories, and tags tables.
     */
    public function run(): void
    {
        $roles = [
            Role::firstOrCreate(['name' => 'admin']),
            Role::firstOrCreate(['name' => 'editor']),
            Role::firstOrCreate(['name' => 'author']),
        ];

        $users = User::factory(10)->create([
            'role_id' => $roles[array_rand($roles)]->id,
        ]);

        $categories = Category::factory(5)->create();

        $tags = Tag::factory(15)->create();

        foreach (range(1, 20) as $_) {
            $post = Post::factory()->create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ]);
            $post->tags()->attach($tags->random(random_int(1, 4))->pluck('id'));
        }
    }
}
