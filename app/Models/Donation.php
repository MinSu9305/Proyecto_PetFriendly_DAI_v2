<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'donor_name',
        'donor_email',
        'amount',
        'status',
        'transaction_id',
        'message',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusInSpanishAttribute()
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'completed' => 'Completada',
            'failed' => 'Fallida',
            default => $this->status,
        };
    }
}
