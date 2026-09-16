<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $authors = User::whereIn('email', [
            'admin@kritissumsel.com', 'editor@kritissumsel.com', 'penulis@kritissumsel.com',
        ])->get();

        $categories = Category::all();

        $tags = Tag::factory()->count(12)->create();

        Article::factory()
            ->count(40)
            ->recycle($authors)
            ->recycle($categories)
            ->create()
            ->each(function (Article $article) use ($tags) {
                $article->tags()->attach($tags->random(random_int(2, 4))->pluck('id'));
                Comment::factory()
                    ->count(random_int(0, 5))
                    ->for($article)
                    ->recycle(User::all())
                    ->create();
            });

        Article::inRandomOrder()->take(5)->update(['is_featured' => true]);
        Article::inRandomOrder()->take(3)->update(['is_breaking' => true]);
    }
}
