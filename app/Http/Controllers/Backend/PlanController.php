<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('users')->latest()->get();
        return view('backend.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('backend.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'code'       => ['required', 'string', 'max:50', 'unique:plans,code'],
            'price'      => ['required', 'numeric', 'min:0'],
            'base_value' => ['required', 'numeric', 'min:0'],
            'daily_cap'  => ['required', 'numeric', 'min:0'],
            'total_cap'  => ['required', 'numeric', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Plan::create($validated);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function edit(string $id)
    {
        $plan = Plan::findOrFail($id);
        return view('backend.plans.edit', compact('plan'));
    }

    public function update(Request $request, string $id)
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'code'       => ['required', 'string', 'max:50', 'unique:plans,code,' . $id],
            'price'      => ['required', 'numeric', 'min:0'],
            'base_value' => ['required', 'numeric', 'min:0'],
            'daily_cap'  => ['required', 'numeric', 'min:0'],
            'total_cap'  => ['required', 'numeric', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $plan->update($validated);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully.');
    }

    public function destroy(string $id)
    {
        Plan::findOrFail($id)->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully.');
    }

    public function export()
    {
        $plans = Plan::withCount('users')->latest()->get();

        $filename = 'plans_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($plans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Code', 'Price (₹)', 'Base Value', 'Daily Cap (₹)', 'Total Cap (₹)', 'Active Members', 'Status']);
            foreach ($plans as $plan) {
                fputcsv($handle, [
                    $plan->id,
                    $plan->name,
                    $plan->code,
                    $plan->price,
                    $plan->base_value,
                    $plan->daily_cap,
                    $plan->total_cap,
                    $plan->users_count,
                    $plan->is_active ? 'Active' : 'Inactive',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
