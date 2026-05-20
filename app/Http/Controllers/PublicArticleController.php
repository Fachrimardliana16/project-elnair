<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\SiteSetting;

class PublicArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'published')->orderBy('created_at', 'desc')->paginate(9);
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        
        $page_title = 'Artikel & Blog';
        $meta_description = 'Kumpulan artikel informatif seputar ibadah Umrah dan Haji, tips perjalanan, serta panduan manasik.';

        return view('landing.articles.index', compact('articles', 'settings', 'page_title', 'meta_description'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $related = Article::where('status', 'published')->where('id', '!=', $article->id)->inRandomOrder()->limit(3)->get();
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        $page_title = $article->title;
        $meta_description = \Illuminate\Support\Str::limit(strip_tags($article->content), 160);

        return view('landing.articles.show', compact('article', 'related', 'settings', 'page_title', 'meta_description'));
    }
}
