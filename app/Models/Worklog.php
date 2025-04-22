<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worklog extends Model
{
    protected $fillable = ['user_id', 'date', 'hours', 'comment', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}