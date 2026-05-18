<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['responsible_id','student_id','type','validated','scheduled_for','comeback','return_scheduled_for','reason'])]

class Ticket extends Model
{
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }
}
