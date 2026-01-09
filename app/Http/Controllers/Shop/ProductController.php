<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with search, filter, sort, and pagination.
     *
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = Product::query()
        ->orderByRaw('stock = 0 ASC') 
        ->orderBy('created_at', 'DESC');;

        // Search for name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('type', 'brand')
                    ->where('name', $request->brand);
            });
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('type', 'gender')
                    ->where('name', $request->gender);
            });
        }

        // Filter by usage
        if ($request->filled('usage')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('type', 'usage')
                    ->where('name', $request->usage);
            });
        }

        // Filter by minimum price 
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filter by maximum price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $brands = Category::where('type', 'brand')->orderBy('name')->get();
        $genders = Category::where('type', 'gender')->orderBy('name')->get();
        $usages = Category::where('type', 'usage')->orderBy('name')->get();

        return view('shop.products.index', compact('products', 'brands', 'genders', 'usages'));
    }

    /**
     * Show the product page.
     *
     * @param Product $product
     * @return \Illuminate\View
     */
    public function show(Product $product)
    {
        $product = Product::findOrFail($product->id);
        $variants = Product::where('name', $product->name)
        ->where('id', '!=', $product->id)->get();
        return view('shop.products.show', compact('product', 'variants'));

    }

    /**
     * Show the product page.

    * @param Product $product
    * @return \Illuminate\View
    */
    public function home()
    {
        $latestProducts = Product::with('categories')
        ->where('stock', '>', 0)
        ->latest()
        ->take(6)
        ->get();

        $brands = Category::where('type', 'brand')->get();
        $usages = Category::where('type', 'usage')->get();
        $genders = Category::where('type', 'gender')->get();

        return view('welcome', compact('latestProducts', 'brands', 'usages', 'genders'));
    }

    /**
     * Show the latest products page.
     *
     * @return \Illuminate\View
     */
    public function newArrivals()
    {
        $allProducts = Product::latest()->take(20)->get();
        $currentPage = Paginator::resolveCurrentPage('page');
        $perPage = 12;
        $currentPageItems = $allProducts->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $products = new LengthAwarePaginator(
            $currentPageItems,
            $allProducts->count(), // total de productos
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()] // mantiene la URL
        );

        $brands = Category::where('type', 'brand')->get();
        $usages = Category::where('type', 'usage')->get();
        $genders = Category::where('type', 'gender')->get();

        return view('shop.products.new_arrivals', compact('products', 'brands', 'genders', 'usages',));
    }
}

