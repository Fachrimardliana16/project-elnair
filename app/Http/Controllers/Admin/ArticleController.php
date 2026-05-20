<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $articles = Article::with('author')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()->paginate(20)->withQueryString();
        return view('admin.articles.index', compact('articles', 'search'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();

        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['author_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('thumbnail'), 'assets/img/articles');
        }

        Article::create($data);

        Cache::forget('homepage_articles');

        return redirect()->route('admin.articles.index')->with('success', 'Article published!');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public_root')->delete($article->thumbnail);
            }
            $data['thumbnail'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('thumbnail'), 'assets/img/articles');
        }

        $article->update($data);

        Cache::forget('homepage_articles');

        return redirect()->route('admin.articles.index')->with('success', 'Article updated!');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public_root')->delete($article->thumbnail);
        }
        $article->delete();
        Cache::forget('homepage_articles');
        return back()->with('success', 'Article deleted!');
    }
}
