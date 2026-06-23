<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Article;
use App\Models\LandingPageLead;
use App\Models\User;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $activePackages    = Package::where('is_active', true)->count();
        $publishedArticles = Article::where('status', 'published')->count();
        $leadsThisMonth    = LandingPageLead::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();
        $dealsThisMonth    = LandingPageLead::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->where('status', 'deal')
                                ->count();
        $totalUsers        = User::count();
        $recentLeads       = LandingPageLead::with('landingPage')
                                ->latest()
                                ->take(5)
                                ->get();
                                
        $visitorsToday = Visitor::where('visited_date', today())->count();
        $totalVisitors = Visitor::count();
        $totalHits     = Visitor::sum('hits');

        return view('admin.dashboard', compact(
            'activePackages',
            'publishedArticles',
            'leadsThisMonth',
            'dealsThisMonth',
            'totalUsers',
            'recentLeads',
            'visitorsToday',
            'totalVisitors',
            'totalHits'
        ));
    }
}
