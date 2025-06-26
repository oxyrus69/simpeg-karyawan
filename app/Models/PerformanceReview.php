<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'tanggal_review',
        'skor_kinerja',
        'komentar',
    ];

    /**
     * Get the employee that the review belongs to.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}