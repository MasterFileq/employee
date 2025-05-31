<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worklog extends Model
{
    use HasFactory;

    //statusy
    public const STATUS_PENDING = 'oczekujący';
    public const STATUS_APPROVED = 'zatwierdzony';
    public const STATUS_REJECTED = 'odrzucony';

    protected $fillable = [
        'user_id',
        'date',
        'hours',
        'comment',
        'created_by',
        'status',
        'approved_by',
        'approved_at',
        'rejection_comment',
        'approval_comment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date', 
        'approved_at' => 'datetime', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}