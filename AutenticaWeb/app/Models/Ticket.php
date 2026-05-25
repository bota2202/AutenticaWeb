<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'responsible_id',
    'student_name',
    'professor_id',
    'confirmational_id',
    'type',
    'validated',
    'reason',
    'scheduled_for',
    'absence_1',
    'absence_2',
    'absence_3',
    'absence_4',
    'absence_5',
    'comeback',
    'status',
    'return_scheduled_for',
])]
class Ticket extends Model
{
    protected function casts(): array
    {
        return [
            'validated' => 'boolean',
            'comeback' => 'boolean',
            'absence_1' => 'boolean',
            'absence_2' => 'boolean',
            'absence_3' => 'boolean',
            'absence_4' => 'boolean',
            'absence_5' => 'boolean',
            'scheduled_for' => 'datetime',
            'return_scheduled_for' => 'datetime',
        ];
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function confirmational()
    {
        return $this->belongsTo(User::class, 'confirmational_id');
    }
}
