<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'role_label' => 'required|string',
            'quote' => 'required|string',
            'avatar' => 'nullable|image|max:1024',
            'thumbnail' => 'nullable|image|max:1024',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('avatar'), 'assets/img/testimonials');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('thumbnail'), 'assets/img/testimonials');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'role_label' => 'required|string',
            'quote' => 'required|string',
            'avatar' => 'nullable|image|max:1024',
            'thumbnail' => 'nullable|image|max:1024',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('avatar'), 'assets/img/testimonials');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('thumbnail'), 'assets/img/testimonials');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted!');
    }
}
