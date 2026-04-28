<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\UserTree;
use App\Jobs\DistributeIncomeJob;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'reference_code' => ['nullable', 'string', 'max:50', 'exists:users,reference_code'],
            'password'       => ['required', 'confirmed', 'min:8'],
        ]);

        // Auto-generate unique user_id
        do {
            $userId = 'KMW' . strtoupper(Str::random(6));
        } while (User::where('user_id', $userId)->exists());

        // Auto-generate unique referral code
        do {
            $referralCode = 'REF' . strtoupper(Str::random(6));
        } while (User::where('reference_code', $referralCode)->exists());

        // Resolve sponsor
        $referredBy = null;
        $sponsorId = null;
        $parentId = null;
        if (!empty($validated['reference_code'])) {
            $referrer = User::where('reference_code', $validated['reference_code'])->first();
            if ($referrer) {
                $referredBy = $referrer->id;
                $sponsorId = $referrer->id;

                $existingDirects = User::query()
                    ->where(function ($query) use ($referrer) {
                        $query->where('sponsor_id', $referrer->id)
                            ->orWhere(function ($legacy) use ($referrer) {
                                $legacy->whereNull('sponsor_id')
                                    ->where('referred_by', $referrer->id);
                            });
                    })
                    ->count();

                $parentId = $existingDirects < 10 ? $referrer->id : null;
            }
        }

        $user = User::create([
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'] ?? null,
            'user_id'        => $userId,
            'reference_code' => $referralCode,
            'referred_by'    => $referredBy,
            'sponsor_id'     => $sponsorId,
            'parent_id'      => $parentId,
            'password'       => Hash::make($validated['password']),
            'status'         => 'active',
        ]);

        // Build MLM upline tree
        $sponsor = User::find($user->referred_by);
        $level   = 1;
        while ($sponsor && $level <= 20) {
            UserTree::create([
                'user_id'   => $user->id,
                'upline_id' => $sponsor->id,
                'level'     => $level,
            ]);
            $sponsor = User::find($sponsor->referred_by);
            $level++;
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing a user.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->update(['name' => $validated['name'], 'email' => $validated['email']]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', 'min:8']]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Export all users to CSV.
     */
    public function export()
    {
        $users = User::latest()->get();

        $filename = 'users_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');
            // CSV header row
            fputcsv($handle, ['ID', 'User ID', 'Name', 'Email', 'Phone', 'Reference Code', 'Status', 'Has Plan', 'Wallet Balance', 'Total Earned', 'Joined']);
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->user_id ?? '',
                    $user->name,
                    $user->email,
                    $user->phone ?? '',
                    $user->reference_code ?? '',
                    $user->status ?? '',
                    $user->has_plan ? 'Yes' : 'No',
                    $user->wallet_balance ?? 0,
                    $user->total_earned ?? 0,
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Toggle user active/blocked status.
     */
    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);

        // Toggle user active/blocked status
        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();

        $label = $user->status === 'active' ? 'unblocked' : 'blocked';

        ActivityLogger::log("user_{$label}", 'User', $user->id, ['name' => $user->name]);

        return redirect()->back()->with('success', "User {$user->name} has been {$label}.");
    }

    /**
     * Show all income records for a specific user.
     */
    public function income(string $id)
    {
        $user    = User::findOrFail($id);
        $incomes = Income::with('fromUser')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $totalCredited = Income::where('user_id', $user->id)->where('status', 'credited')->sum('amount');
        $totalLost     = Income::where('user_id', $user->id)->where('status', 'lost')->sum('amount');
        $totalEarnings = Income::where('user_id', $user->id)->sum('amount');

        return view('backend.users.income', compact('user', 'incomes', 'totalCredited', 'totalLost', 'totalEarnings'));
    }

    /**
     * Show MLM downline tree for a user.
     */
    public function tree(string $id)
    {
        $user = User::findOrFail($id);

        $downlines = UserTree::with('user')
            ->where('upline_id', $user->id)
            ->orderBy('level')
            ->paginate(50);

        $downlineCount = UserTree::where('upline_id', $user->id)->count();

        return view('backend.users.tree', compact('user', 'downlines', 'downlineCount'));
    }

    /**
     * Show plan history and assign-plan form for a user.
     */
    public function planHistory(string $id)
    {
        $user        = User::findOrFail($id);
        $planHistory = UserPlan::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        $plans = Plan::orderBy('price')->get();

        return view('backend.users.plan-history', compact('user', 'planHistory', 'plans'));
    }

    /**
     * Manually assign a plan to a user.
     */
    public function assignPlan(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'plan_id'    => 'required|exists:plans,id',
            'amount_paid'=> 'nullable|numeric|min:0',
        ]);

        $plan       = Plan::findOrFail($validated['plan_id']);
        $amountPaid = $validated['amount_paid'] ?? $plan->price;

        UserPlan::create([
            'user_id'      => $user->id,
            'plan_id'      => $plan->id,
            'amount_paid'  => $amountPaid,
            'status'       => 'active',
            'activated_at' => now(),
        ]);

        $user->update([
            'has_plan'        => 1,
            'current_plan_id' => $plan->id,
            'status'          => 'active',
        ]);

        if ($request->boolean('distribute_income')) {
            DistributeIncomeJob::dispatch($user->id);
        }

        ActivityLogger::log('plan_assigned', 'User', $user->id, [
            'plan'   => $plan->name,
            'amount' => $amountPaid,
        ]);

        return redirect()->back()->with('success', "Plan '{$plan->name}' assigned to {$user->name}.");
    }
}
