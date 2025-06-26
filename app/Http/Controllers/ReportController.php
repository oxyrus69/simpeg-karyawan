<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\PerformanceReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function performance()
    {
        // 1. Data untuk Grafik Tren Kinerja Bulanan
        $monthlyPerformance = PerformanceReview::select(
                DB::raw('DATE_FORMAT(tanggal_review, "%Y-%m") as month'),
                DB::raw('avg(skor_kinerja) as average_score')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // Memformat data untuk Chart.js
        $monthlyLabels = $monthlyPerformance->pluck('month');
        $monthlyScores = $monthlyPerformance->pluck('average_score');

        // 2. Data untuk Tabel Rata-rata per Departemen
        $departmentPerformance = Department::with('employees.performanceReviews')
            ->get()
            ->map(function ($department) {
                // Mengumpulkan semua review dari semua karyawan di departemen ini
                $reviews = $department->employees->flatMap(function ($employee) {
                    return $employee->performanceReviews;
                });

                return [
                    'nama_departemen' => $department->nama_departemen,
                    'rata_rata_skor' => $reviews->avg('skor_kinerja') ?: 0,
                    'jumlah_review' => $reviews->count(),
                ];
            });

        return view('reports.performance', compact(
            'monthlyLabels',
            'monthlyScores',
            'departmentPerformance'
        ));
    }
}