<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Get the cart view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get cart
        $cartItems = session()->get('cart', []);

        // Get shipping config
        $shippingConfig = Setting::first() ?? new Setting();
        $subtotal = 0;

        // Calculate subtotal
        foreach ($cartItems as $key => $item) {
            if(!isset($item['quantity'], $item['price'], $item['name'])) {
                unset($cartItems[$key]);
                continue;
            }
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Calculate shipping 
        $baseShipping = $shippingConfig->shipping_cost ?? 0;
        $freeShippingMin = $shippingConfig->free_shipping_min ?? 0;

        if ($subtotal == 0) {
            $shipping = 0;
        } else {
            $shipping = ($subtotal >= $freeShippingMin) ? 0 : $baseShipping;
        }

        $total = $subtotal + $shipping;
        $howMuchFor = ($subtotal < $freeShippingMin) ? ($freeShippingMin - $subtotal) : 0;
        session()->put('cart', $cartItems);
        $brands = Category::where('type', 'brand')->get();

        return view('cart.index', compact('cartItems','subtotal','shipping','total','freeShippingMin', 'howMuchFor'));
    }
 
    /**
     * Add a product to the cart
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, $id)
    {
        // Get product with categories
        $product = Product::with('categories')->find($id);

        if (!$product) {
            return redirect()->back()->with('error', __('Product not found.'));
        }

        $brandCategory = $product->categories->where('type', 'brand')->first();

        // Quantity requested (default 1)
        $quantity = $request->input('quantity', 1);

        // Get size
        $size = $request->input('size', '40');
        $cartKey = $id . '-' . $size;

        // Check stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', __('Not enough stock available.'));
        }

        // Get cart from session
        $cart = session()->get('cart', []);

        // Check if product is already in cart
        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] += $quantity;

            // Do not allow adding more units than available stock
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', __('You cannot add more units than available stock.'));
            }
        } else {
            // Add new product to cart
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'img' => $product->img ?? null,
                'size' => $size,
                'brand' => $brandCategory->name
            ];
        }

        // Save cart to session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', $product->name . __(' has been added to the cart.'));
    }

    /**
     * Update product quantity in cart
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if($request->action == 'increment') {
                // Buscamos el producto para ver su stock real
                $product = Product::find($cart[$id]['id']);
            
                if($product && $cart[$id]['quantity'] < $product->stock) {
                    $cart[$id]['quantity']++;
                } else {
                    return redirect()->back()->with('error', __('Not enough stock available for ' . $product->name));
                }
            } else if($request->action == 'decrement' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            }
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    /**
     * Remove product from cart
     *
     * @param int $id The product id to be removed from the cart
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', $product->name . __(' has been removed from the cart.'));
    }
}
