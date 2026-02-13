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
        'status',
        'cancel_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

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
}
