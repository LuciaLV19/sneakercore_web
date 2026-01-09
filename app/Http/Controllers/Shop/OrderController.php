<?php

namespace App\Http\Controllers\Shop;

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
     * Display a listing of the user's orders.
     * @return \Illuminate\View\View
     */
    public function index()
{
    $orders = Order::with('items.product')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders.index', compact('orders'));
}

    /**
     * Store a newly created order in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('Please log in to place an order.'));
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $address = $user->getCheckoutAddress();

        if (!$address) {
            return redirect()->route('profile.edit')->with('info', __('Please add an address.'));
        }

        $addressString = "{$address->address_line}, ({$address->postal_code}), {$address->country}";

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty'));
        }

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $orderItems = [];

            foreach ($cart as $cartKey => $item) {
                $product = Product::findOrFail($item['id']);
                $quantity = $item['quantity'];

                if (!$product || $product->stock < $quantity) {
                    throw new \Exception(__('Product') . " {$product->name} " . __('is out of stock.'));
                }

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'size' => $item['size'],
                ];

                $totalAmount += $product->price * $quantity;
                $product->decrement('stock', $quantity);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'city' => (string)$address->city,
                'shipping_address' => (string)$addressString,
                'payment_method' => $request->input('payment_method', 'Credit Card'),
                'status' => 'Processing',
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }
            DB::commit();
            Session::forget('cart');
            return redirect()->route('shop.index')->with('success', __('Order placed successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('shop.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
