<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist items.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlistItems = session()->get('wishlist', []);

        $wishlistItems = collect($wishlistItems);
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Toggle a product in the wishlist
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request, $id)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => __('Please login')], 401);
            }
            return redirect()->route('login');
        }

        $product = Product::with('categories')->findOrFail($id);
        $wishlist = session()->get('wishlist', []);
        $added = false;

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            $message = __(':name has been removed from the wishlist.', ['name' => $product->name]);
        } else {
            $wishlist[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'img' => 'images/products/' . '/' . $product->img,
            ];
            $message = __(':name has been added to the wishlist.', ['name' => $product->name]);
            $added = true;
        }

        session()->put('wishlist', $wishlist);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'added' => $added,
                'count' => count($wishlist)
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
