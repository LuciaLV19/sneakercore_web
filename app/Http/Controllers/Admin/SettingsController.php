<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    /**
     * Returns the view for the admin settings page with the existing settings.
     * If no settings exist, a new Setting instance is created and passed to the view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $settings = Setting::first() ?? new Setting();

        return view('admin.settings.shipping', compact('settings'));
    }

    /**
     * Updates the shipping settings in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'shipping_cost'     => 'required|numeric|min:0',
            'free_shipping_min' => 'required|numeric|min:0',
        ]);

        Setting::updateOrCreate(
            ['id' => 1],
            [
                'shipping_cost'     => $request->shipping_cost,
                'free_shipping_min' => $request->free_shipping_min,
            ]
        );

        return redirect()->back()->with('success', __('Shipping settings updated successfully.'));
    }
}