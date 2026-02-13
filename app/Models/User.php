<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image_path',
        'is_approved',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'rejected_at',
        'rejected_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'is_approved' => 'boolean',
        ];
    }

    public function paymentProofs()
    {
        return $this->hasMany(PaymentProof::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function approvalLogs()
    {
        return $this->hasMany(ApprovalLog::class)->latest();
    }

    public function files()
    {
        return $this->hasMany(File::class, 'module_id')->where('module_name', 'user');
    }

    public function profileImage()
    {
        return $this->hasOne(File::class, 'module_id')
                    ->where('module_name', 'user')
                    ->where('file_type', 'image')
                    ->latest('id');
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image_path) {
            return Storage::disk('public')->url($this->profile_image_path);
        }
        return 'https://i.pravatar.cc/40?u=' . $this->id;
    }
}
