@extends('admin.layouts.app')
@section('title', 'Marketing Ads')
@section('page_title', 'Marketing Ads')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="margin: 0;">Ads List</h3>
        <a href="{{ route('admin.ads.create') }}" class="btn-admin"><i class="fas fa-plus"></i> New Ad</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Link</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ads as $ad)
            <tr>
                <td>{{ $ad->title }}</td>
                <td><a href="{{ $ad->link }}" target="_blank" style="font-size: 0.8rem; color: #4a90e2;">{{ $ad->link }}</a></td>
                <td>
                    <span style="background: {{ $ad->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $ad->is_active ? '#155724' : '#721c24' }}; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">
                        {{ $ad->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.ads.edit', $ad->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.ads.destroy', $ad->id) }}" method="POST">
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
