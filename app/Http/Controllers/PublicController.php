<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $categories = Category::active()->whereNull('parent_id')->orderBy('order')->get();

        return view('public.home', compact('categories'));
    }

    public function categoryShow(string $slug): View
    {
        $category = Category::active()->where('slug', $slug)->with(['parent', 'children' => fn ($q) => $q->active()->orderBy('order')])->firstOrFail();

        return view('public.category', compact('category'));
    }

    public function tagShow(string $slug): View
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        return view('public.tag', compact('tag'));
    }

    public function articleShow(string $slug): View
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->with(['category', 'author', 'tags', 'media' => fn ($q) => $q->orderBy('order')])
            ->firstOrFail();

        $article->increment('views_count');
        $article->views()->create([
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 255),
        ]);

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('public.article', compact('article', 'related'));
    }

    public function search(): View
    {
        return view('public.search');
    }

    public function authorShow(string $username): View
    {
        $author = User::where('username', $username)->firstOrFail();

        $articles = Article::published()
            ->where('user_id', $author->id)
            ->with('category')
            ->latest('published_at')
            ->paginate(9);

        return view('public.author', compact('author', 'articles'));
    }

    public function about(): View
    {
        return view('public.pages.about');
    }

    public function redaksi(): View
    {
        return view('public.pages.redaksi');
    }

    public function contact(): View
    {
        return view('public.pages.contact');
    }

    public function privacy(): View
    {
        return view('public.pages.privacy');
    }

    public function newsletterVerify(string $token): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::where('verification_token', $token)->firstOrFail();

        $subscriber->update(['is_verified' => true, 'verification_token' => null]);

        return redirect()->route('home')->with('newsletter_verified', true);
    }
}
