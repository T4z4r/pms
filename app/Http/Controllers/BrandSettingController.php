<?php

namespace App\Http\Controllers;

use App\Models\BrandSetting;
use Illuminate\Http\Request;

class BrandSettingController extends Controller
{
    public function index()
    {
        $settings = BrandSetting::all();
        return view('brand_settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        BrandSetting::create($request->all());
        return redirect()->back()->with('success', 'Brand setting added.');
    }

    public function update(Request $request, $id)
    {
        $setting = BrandSetting::findOrFail($id);
        $setting->update($request->all());
        return redirect()->back()->with('success', 'Brand setting updated.');
    }

    public function destroy($id)
    {
        BrandSetting::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Brand setting deleted.');
    }
}
