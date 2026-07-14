<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'day_of_week', 'start_time', 'end_time', 'room', 'color'];

    protected $casts = [
        'day_of_week' => 'integer',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public static function dayLabel(int $day): string
    {
        return ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][$day] ?? '';
    }
}