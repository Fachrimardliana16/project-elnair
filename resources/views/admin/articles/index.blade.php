@extends('admin.layouts.app')
@section('title', 'Articles')
@section('page_title', 'Article Management')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <form method="GET" action="{{ route('admin.articles.index') }}" style="display: flex; gap: 0.5rem; flex: 1; max-width: 400px;">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul artikel..." class="form-control" style="margin: 0;">
            <button type="submit" class="btn-admin" style="white-space: nowrap;"><i class="fas fa-search"></i></button>
            @if($search)
            <a href="{{ route('admin.articles.index') }}" class="btn-admin-outline" style="white-space: nowrap;">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.articles.create') }}" class="btn-admin"><i class="fas fa-plus"></i> New Article</a>
    </div>

    <div class="table-responsive">
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
            @forelse($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->author->name }}</td>
                <td><span style="background: {{ $article->status === 'published' ? '#d4edda' : '#fff3cd' }}; color: {{ $article->status === 'published' ? '#155724' : '#856404' }}; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">{{ ucfirst($article->status) }}</span></td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.articles.edit', $article->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn" style="background: none; border: none; color: #e74c3c; cursor: pointer;"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align: center; color: #888; padding: 2rem;">
                {{ $search ? 'Artikel dengan kata kunci "'.$search.'" tidak ditemukan.' : 'Belum ada artikel.' }}
            </td></tr>
            @endforelse
        </tbody>
    </table>
    @if($articles->hasPages())
    <div class="mt-3 d-flex justify-content-end">{{ $articles->links() }}</div>
    @endif
    </div>
</div>
@endsection
