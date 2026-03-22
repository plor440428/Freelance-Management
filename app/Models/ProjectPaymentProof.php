<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectPaymentProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'submitted_as',
        'amount',
        'slip_file',
        'note',
        'status',
        'reviewed_amount',
        'review_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'reviewed_amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getSlipFileUrlAttribute(): string
    {
        if ($this->slip_file) {
            return Storage::disk('public')->url($this->slip_file);
        }
        return '';
    }
}
