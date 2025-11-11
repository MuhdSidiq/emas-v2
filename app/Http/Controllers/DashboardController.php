<?php

namespace App\Http\Controllers;

use App\Models\ProductData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user()->load(['role', 'profitMargin']);

        $stats = [
            'total_users' => User::count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'total_products' => ProductData::count(),
            'low_stock_count' => ProductData::whereColumn('stock', '<=', 'low_stock_threshold')->count(),
        ];

        $recentUsers = User::with('role')
            ->latest()
            ->limit(5)
            ->get();

        $lowStockProducts = ProductData::whereColumn('stock', '<=', 'low_stock_threshold')
            ->orderBy('stock')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
