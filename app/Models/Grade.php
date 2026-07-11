<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'subject_id', 'assignment', 'quiz',
        'midterm', 'final', 'average', 'grade', 'approved',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function calculateAverage(): float
    {
        // Weighted: assignment 20%, quiz 20%, midterm 25%, final 35%
        return round(
            ($this->assignment * 0.20) + ($this->quiz * 0.20) +
            ($this->midterm * 0.25) + ($this->final * 0.35), 2
        );
    }

    public static function letterGrade(float $average): string
    {
        return match (true) {
            $average >= 90 => 'A',
            $average >= 80 => 'B',
            $average >= 70 => 'C',
            $average >= 60 => 'D',
            default => 'F',
        };
    }
}
