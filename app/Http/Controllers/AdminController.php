<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_products'   => Product::count(),
            'active_products'  => Product::active()->count(),
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
            'avg_price'        => Product::avg('price'),
            'top_products'     => Product::orderBy('price', 'desc')->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
