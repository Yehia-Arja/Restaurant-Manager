<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlatformInsight;
use App\Jobs\CalculatePlatformInsightsJob;
use Carbon\Carbon;

class PlatformInsightController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->filled('month')) {
                $insight = PlatformInsight::where('month', $request->input('month'))
                                          ->firstOrFail();
            } else {
                $insight = PlatformInsight::orderByDesc('month')->firstOrFail();
            }

            return $this->success('Platform insights retrieved successfully.', $insight);
        } catch (\Throwable $e) {
            return $this->error('Failed to fetch platform insights.');
        }
    }

    public function months()
    {
        try {
            $months = PlatformInsight::query()
                ->select('month')
                ->distinct()
                ->orderByDesc('month')
                ->pluck('month')
                ->map(function (string $ym) {
                    return [
                        'value' => $ym,
                        'label' => Carbon::createFromFormat('Y-m', $ym)->format('F-Y'),
                    ];
                })
                ->values();

            return $this->success('Available months fetched.', $months);
        } catch (\Throwable $e) {
            return $this->error('Failed to fetch months.');
        }
    }

    public function refresh(Request $request)
    {
        try {
            $month = $request->input('month') ?: Carbon::now()->format('Y-m');

            CalculatePlatformInsightsJob::dispatchSync($month);

            $insight = PlatformInsight::where('month', $month)->firstOrFail();

            return $this->success('Platform insights refreshed successfully.', $insight);
        } catch (\Throwable $e) {
            return $this->error('Failed to refresh platform insights.');
        }
    }

}
