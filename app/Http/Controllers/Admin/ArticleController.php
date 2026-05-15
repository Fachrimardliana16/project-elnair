<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|string',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('assets/img/articles', 'public_root');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article published!');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|string',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('assets/img/articles', 'public_root');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated!');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Article deleted!');
    }
}
