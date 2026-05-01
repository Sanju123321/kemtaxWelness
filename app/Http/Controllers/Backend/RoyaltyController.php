<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RoyaltyController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->baseRoyaltyQuery();
        $this->applyRoyaltyFilters($query, $request);

        $rows = $query
            ->orderByDesc('direct_referrals')
            ->paginate(20)
            ->withQueryString();
        $rows->through(function ($row) {
            $row->royalty_percentage = $this->percentageForDirects((int) $row->direct_referrals);
            return $row;
        });

        $totals = [
            '10' => (clone $this->baseRoyaltyQuery())->havingBetween('direct_referrals', [15, 19])->count(),
            '15' => (clone $this->baseRoyaltyQuery())->havingBetween('direct_referrals', [20, 29])->count(),
            '18' => (clone $this->baseRoyaltyQuery())->havingBetween('direct_referrals', [30, 49])->count(),
            '20' => (clone $this->baseRoyaltyQuery())->having('direct_referrals', '=', 50)->count(),
        ];

        return view('backend.royalty.index', [
            'rows' => $rows,
            'filters' => $request->only(['search', 'royalty', 'direct_min', 'direct_max', 'status']),
            'totals' => $totals,
        ]);
    }

    public function export(Request $request)
    {
        $query = $this->baseRoyaltyQuery();
        $this->applyRoyaltyFilters($query, $request);
        $rows = $query->orderByDesc('direct_referrals')->get();

        $filename = 'royalty_report_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['User ID', 'Name', 'Email', 'Phone', 'Status', 'Direct Referrals', 'Royalty %']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->user_id,
                    $row->name,
                    $row->email,
                    $row->phone,
                    ucfirst((string) $row->status),
                    (int) $row->direct_referrals,
                    $this->percentageForDirects((int) $row->direct_referrals) . '%',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    private function baseRoyaltyQuery(): Builder
    {
        return User::query()
            ->select('id', 'user_id', 'name', 'email', 'phone', 'status', 'created_at')
            ->selectSub(function ($sub) {
                $sub->from('users as d')
                    ->selectRaw('COUNT(*)')
                    ->where(function ($q) {
                        $q->whereColumn('d.sponsor_id', 'users.id')
                            ->orWhere(function ($legacy) {
                                $legacy->whereNull('d.sponsor_id')
                                    ->whereColumn('d.referred_by', 'users.id');
                            });
                    });
            }, 'direct_referrals')
            ->havingBetween('direct_referrals', [15, 50]);
    }

    private function applyRoyaltyFilters(Builder $query, Request $request): void
    {
        $search = trim((string) $request->query('search', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('user_id', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $status = strtolower((string) $request->query('status', ''));
        if (in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        $min = max(15, (int) $request->query('direct_min', 15));
        $max = (int) $request->query('direct_max', 50);
        $max = min(50, max($min, $max));
        $query->havingBetween('direct_referrals', [$min, $max]);

        $royalty = (string) $request->query('royalty', '');
        if ($royalty === '10') {
            $query->havingBetween('direct_referrals', [15, 19]);
        } elseif ($royalty === '15') {
            $query->havingBetween('direct_referrals', [20, 29]);
        } elseif ($royalty === '18') {
            $query->havingBetween('direct_referrals', [30, 49]);
        } elseif ($royalty === '20') {
            $query->having('direct_referrals', '=', 50);
        }
    }

    public function percentageForDirects(int $directs): int
    {
        if ($directs >= 50) {
            return 20;
        }
        if ($directs >= 30) {
            return 18;
        }
        if ($directs >= 20) {
            return 15;
        }

        return 10;
    }
}
