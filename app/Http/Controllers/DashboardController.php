<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\PerformanceReview;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // --- Logika untuk ADMIN ---
        if ($user->role === 'admin') {
            $totalKaryawan = Employee::count();
            $totalDepartemen = Department::count();
            $totalJabatan = Position::count();
            $departmentData = Department::withCount('employees')->get();
            $chartLabels = $departmentData->pluck('nama_departemen');
            $chartData = $departmentData->pluck('employees_count');
            $latestEmployees = Employee::with('position')->latest()->take(5)->get();
            $recentReviews = PerformanceReview::with('employee')->latest('tanggal_review')->take(5)->get();

            return view('dashboard', compact(
                'totalKaryawan', 'totalDepartemen', 'totalJabatan',
                'chartLabels', 'chartData', 'latestEmployees', 'recentReviews'
            ));
        }

        // --- Logika untuk MANAJER ---
        if ($user->role === 'manager') {
            $managerProfile = $user->employee;

            if ($managerProfile) {
                $departmentId = $managerProfile->department_id;

                // Data untuk kartu statistik manajer
                $totalTeamMembers = Employee::where('department_id', $departmentId)
                                            ->where('id', '!=', $managerProfile->id)
                                            ->count();

                // Data aktivitas terbaru untuk tim manajer
                $latestTeamHires = Employee::where('department_id', $departmentId)
                                            ->latest()
                                            ->take(5)
                                            ->get();

                $recentTeamReviews = PerformanceReview::whereHas('employee', function ($query) use ($departmentId) {
                                                $query->where('department_id', $departmentId);
                                            })
                                            ->with('employee')
                                            ->latest('tanggal_review')
                                            ->take(5)
                                            ->get();

                // Tampilkan view dashboard khusus untuk manajer
                return view('dashboards.manager', compact(
                    'managerProfile',
                    'totalTeamMembers',
                    'latestTeamHires',
                    'recentTeamReviews'
                ));
            }
        }
        
        // --- Logika Default untuk KARYAWAN ---
        $employee = $user->employee()->with(['department', 'position', 'performanceReviews'])->first();
        return view('dashboards.employee', compact('employee'));
    }
}
