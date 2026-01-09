<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    /**
     * Index page for products.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })
            ->paginate(7)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Displays the create product form with categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'categories' => 'required|array',
            'stock' => 'nullable|integer|min:0',
            'img' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = Product::create($data);

        // Handle image upload and naming
        $brandCategory = \App\Models\Category::whereIn('id', $data['categories'] ?? [])
            ->where('type', 'brand')
            ->first();

        // If an image is uploaded and a brand category is found
        if ($request->hasFile('img') && $brandCategory) {
            $brandName = trim($brandCategory->name);
            $brandSlug = strtolower(str_replace(' ', '_', $brandName));
            $file = $request->file('img');

            // Clean product name - Remove brand name from product name
            $cleanProductName = trim(str_ireplace($brandName, '', $request->name));
            $cleanProductName = preg_replace('/\s+/', ' ', $cleanProductName);
            $productNameSlug = strtolower(str_replace(' ', '_', $cleanProductName));

            $exists = Product::where('name', $request->name)->where('id', '!=', $product->id)->exists();

            $finalSlug = $exists ? $productNameSlug . '_' . $product->id : $productNameSlug;

            $filename = $brandSlug . '_' . $finalSlug . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/products/' . $brandSlug);

            // Move the uploaded file to the destination path
            if (!file_exists($destinationPath . '/' . $filename)) {
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $filename);
            }
            $data['img'] = $brandSlug . '/' . $filename;
            $product->update(['img' => $brandSlug . '/' . $filename]);
        }

        // Sync categories
        if (!empty($data['categories'])) {
            $product->categories()->sync($data['categories'] ?? []);
        }

        return redirect()->route('admin.products.index')
        ->with('success', __('Product created successfully'));
    }

    /**
     * Edit the selected product
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'categories' => 'required|array',
            'stock' => 'nullable|integer',
            'img' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $brandCategory = Category::whereIn('id', $data['categories'])
            ->where('type', 'brand')
            ->first();

        if ($brandCategory) {
            // Prepare naming variables for image handling
            $brandName = trim($brandCategory->name);
            $brandSlug = strtolower(str_replace(' ', '_', $brandName));
            $cleanProductName = trim(str_ireplace($brandName, '', $request->name));
            $cleanProductName = preg_replace('/\s+/', ' ', $cleanProductName);
            $productNameSlug = strtolower(str_replace(' ', '_', $cleanProductName));

            $destinationPath = public_path('images/products/' . $brandSlug);
            $oldImage = $product->img;

            // CASE A: User uploads a new image
            if ($request->hasFile('img')) {

                $file = $request->file('img');

                $exists = Product::where('name', $request->name)->where('id', '!=', $product->id)->exists();
                
                $finalSlug = $exists ? $productNameSlug . '_' . $product->id : $productNameSlug;
                // Case A (Upload new image)
                $filename = $brandSlug . '_' . $finalSlug . '.' . $file->getClientOriginalExtension();

                // Case B (Rename existing image)
                $filename = $brandSlug . '_' . $finalSlug . '.' . $file->getClientOriginalExtension();

                $newFullRoute = $brandSlug . '/' . $filename;

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Delete old image
                if ($oldImage) {
                    $oldPath = public_path('images/products/' . $oldImage);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                // Move uploaded file to destination and update record path
                $file->move($destinationPath, $filename);
                $data['img'] = $newFullRoute;
            }
            // CASE B: User doesn't upload a new image, but changes the product name
            elseif ($oldImage) {
                $extension = pathinfo($oldImage, PATHINFO_EXTENSION);
                $exists = Product::where('name', $request->name)->where('id', '!=', $product->id)->exists();
                $finalSlug = $exists ? $productNameSlug . '_' . $product->id : $productNameSlug;
                
                $filename = $brandSlug . '_' . $finalSlug . '.' . $extension;
                $newFullRoute = $brandSlug . '/' . $filename;

                if ($oldImage !== $newFullRoute) {
                    $oldPath = public_path('images/products/' . $oldImage);
                    $newPath = $destinationPath . '/' . $filename;

                    if (file_exists($oldPath) && !file_exists($newPath)) {
                        rename($oldPath, $newPath);
                        $data['img'] = $newFullRoute;
                    }
                }
            }
        }

        $product->update($data);
        $product->categories()->sync($data['categories']);

        return redirect()->route('admin.products.index')->with('success', __('Product updated successfully'));
    }
    
    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        if ($product->img) {
            $path = public_path('images/products/' . $product->img);
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $product->categories()->detach();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('Product deleted successfully.'));
    }
}
