<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders with search, filter, sort, and pagination.
     *
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.product', 'user']);

        // Search Filter (order ID, customer name, or email)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('id', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    })
                    ->orWhereHas('items.product', function ($productQuery) use ($q) {
                        $productQuery->where('name', 'like', "%{$q}%");
                    });
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ordering Logic (Sort)
        if ($request->sort === 'highest') {
            $query->orderBy('total_amount', 'desc');
        } elseif ($request->sort === 'newest') {
            $query->latest();
        } else {
            $query->latest(); // Orden por defecto
        }

        // Pagination
        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update the status of an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validamos que el estado recibido sea uno de los permitidos
        $validated = $request->validate([
            'status' => 'required|in:Processing,Shipped,Delivered,Cancelled',
        ]);

        // Update order status
        $order->update([
            'status' => $validated['status']
        ]);

        // Redirect with success message
        return back()->with('success', __('Order #:id status updated successfully!', ['id' => $order->id]));
    }
}
