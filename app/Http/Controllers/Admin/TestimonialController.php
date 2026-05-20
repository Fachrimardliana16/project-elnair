<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestimonialRequest;
use App\Http\Requests\Admin\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(20);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(StoreTestimonialRequest $request)
    {
        $data = $request->validated();

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

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) {
                Storage::disk('public_root')->delete($testimonial->avatar);
            }
            $data['avatar'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('avatar'), 'assets/img/testimonials');
        }

        if ($request->hasFile('thumbnail')) {
            if ($testimonial->thumbnail) {
                Storage::disk('public_root')->delete($testimonial->thumbnail);
            }
            $data['thumbnail'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('thumbnail'), 'assets/img/testimonials');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated!');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar) {
            Storage::disk('public_root')->delete($testimonial->avatar);
        }
        if ($testimonial->thumbnail) {
            Storage::disk('public_root')->delete($testimonial->thumbnail);
        }
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted!');
    }
}
