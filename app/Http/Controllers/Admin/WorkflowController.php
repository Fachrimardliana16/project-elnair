<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::orderBy('step_number', 'asc')->get();
        return view('admin.workflows.index', compact('workflows'));
    }

    public function create()
    {
        $nextStep = (Workflow::max('step_number') ?? 0) + 1;
        return view('admin.workflows.create', compact('nextStep'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tagline' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', $validated['step_number']);

        Workflow::create($validated);

        return redirect()->route('admin.workflows.index')->with('success', 'Tahap Alur Kerja berhasil ditambahkan!');
    }

    public function edit(Workflow $workflow)
    {
        return view('admin.workflows.edit', compact('workflow'));
    }

    public function update(Request $request, Workflow $workflow)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tagline' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', $validated['step_number']);

        $workflow->update($validated);

        return redirect()->route('admin.workflows.index')->with('success', 'Tahap Alur Kerja berhasil diperbarui!');
    }

    public function destroy(Workflow $workflow)
    {
        $workflow->delete();
        return redirect()->route('admin.workflows.index')->with('success', 'Tahap Alur Kerja berhasil dihapus!');
    }
}
