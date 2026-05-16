@extends('admin.layouts.app')
@section('title', 'Landing Pages')
@section('page_title', 'Sales Landing Pages')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="margin: 0;">Landing Pages</h3>
        <a href="{{ route('admin.landing-pages.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Create Landing Page</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Auto-URL for Ads</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td><code>/{{ $page->slug }}</code></td>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="text" value="{{ route('landing.page', $page->slug) }}" class="form-control" style="font-size: 0.75rem; padding: 0.3rem;" readonly>
                        <button onclick="copyToClipboard(this)" style="background: none; border: none; cursor: pointer; color: var(--brand-gold);"><i class="fas fa-copy"></i></button>
                    </div>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.landing-pages.edit', $page->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.landing-pages.destroy', $page->id) }}" method="POST">
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

<script>
function copyToClipboard(btn) {
    const input = btn.previousElementSibling;
    input.select();
    document.execCommand('copy');
    alert('URL copied to clipboard!');
}
</script>
@endsection
