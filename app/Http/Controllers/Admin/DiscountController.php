<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Displays a list of all discounts in the system.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new discount.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discounts.create');
    }

    /**
     * Store a newly created discount in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255|unique:discounts,name',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        Discount::create($request->all());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount created successfully.');
    }


    /**
     * Edit the specified discount.
     *
     * @param Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    /**
     * Update the specified discount.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'name'       => 'required|string|max:255|unique:discounts,name,' . $discount->id,
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $discount->update($request->all());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount updated successfully.');
    }

    /**
     * Remove the specified discount from storage.
     *
     * @param Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount deleted successfully.');
    }
}