<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class PaymentProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_type',
        'amount',
        'proof_file',
        'status',
        'admin_note',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getProofFileUrlAttribute()
    {
        return Storage::disk('public')->url($this->proof_file);
    }
}
