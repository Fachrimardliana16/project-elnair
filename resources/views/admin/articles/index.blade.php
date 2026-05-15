@extends('admin.layouts.app')
@section('title', 'Articles')
@section('page_title', 'Article Management')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="margin: 0;">Articles</h3>
        <a href="{{ route('admin.articles.create') }}" class="btn-admin"><i class="fas fa-plus"></i> New Article</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->author->name }}</td>
                <td><span style="background: #e1f5fe; color: #01579b; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">{{ ucfirst($article->status) }}</span></td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.articles.edit', $article->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer;"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
