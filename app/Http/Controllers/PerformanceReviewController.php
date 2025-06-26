<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PerformanceReview;
use Illuminate\Http\Request;

class PerformanceReviewController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function create(Employee $employee)
    {
        return view('reviews.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'tanggal_review' => 'required|date',
            'skor_kinerja' => 'required|integer|min:1|max:100',
            'komentar' => 'required|string',
        ]);

        $reviewData = $request->all();
        $reviewData['employee_id'] = $employee->id;

        PerformanceReview::create($reviewData);

        return redirect()->route('employees.show', $employee->id)
                         ->with('success', 'Penilaian kinerja berhasil ditambahkan.');
    }
}