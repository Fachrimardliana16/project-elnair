<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        if ($request->hasFile('logo')) {
            $data['logo'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('logo'), 'assets/img');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('favicon'), 'assets/img');
        }

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Site settings updated successfully!');
    }
}
