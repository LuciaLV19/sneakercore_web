<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with key statistics.
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_users'    => User::where('role', 0)->count(),
            'recent_orders'  => Order::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
