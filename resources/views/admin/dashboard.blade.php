@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    @can('manage_packages')
    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(13, 76, 84, 0.1); color: var(--brand-dark); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-kaaba"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ \App\Models\Package::count() }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Total Packages</p>
        </div>
    </div>
    @endcan

    @can('manage_testimonials')
    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(139, 94, 60, 0.1); color: var(--brand-gold); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-comment-dots"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ \App\Models\Testimonial::count() }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Testimonials</p>
        </div>
    </div>
    @endcan

    @can('manage_articles')
    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(13, 76, 84, 0.1); color: var(--brand-dark); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-newspaper"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ \App\Models\Article::count() }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Total Articles</p>
        </div>
    </div>
    @endcan

    @can('manage_gallery')
    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(139, 94, 60, 0.1); color: var(--brand-gold); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-images"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ \App\Models\Gallery::count() }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Gallery Items</p>
        </div>
    </div>
    @endcan
</div>


@endsection
