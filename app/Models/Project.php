<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'freelance_id',
        'total_price',
        'installment_count',
        'due_day_of_month',
        'status',
        'cancel_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'installment_count' => 'integer',
        'due_day_of_month' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected function getInstallmentBreakdownSatang(): ?array
    {
        if ($this->total_price === null || (int) $this->installment_count <= 0) {
            return null;
        }

        $totalSatang = (int) round((float) $this->total_price * 100);
        $count = max((int) $this->installment_count, 1);
        $baseSatang = intdiv($totalSatang, $count);
        $lastSatang = $totalSatang - ($baseSatang * ($count - 1));

        return [
            'count' => $count,
            'base_satang' => $baseSatang,
            'last_satang' => $lastSatang,
        ];
    }

    public function getInstallmentBaseAmountAttribute(): ?float
    {
        $breakdown = $this->getInstallmentBreakdownSatang();

        return $breakdown ? $breakdown['base_satang'] / 100 : null;
    }

    public function getInstallmentLastAmountAttribute(): ?float
    {
        $breakdown = $this->getInstallmentBreakdownSatang();

        return $breakdown ? $breakdown['last_satang'] / 100 : null;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function freelance()
    {
        return $this->belongsTo(User::class, 'freelance_id');
    }

    public function customers()
    {
        return $this->belongsToMany(User::class, 'project_customers', 'project_id', 'customer_id');
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'project_managers', 'project_id', 'user_id')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function files()
    {
        return $this->hasMany(File::class, 'module_id')
            ->where('module_name', 'Project');
    }

    public function paymentProofs()
    {
        return $this->hasMany(ProjectPaymentProof::class);
    }
}
