<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'name',
        'company',
        'phone',
        'email',
        'status',
        'created_by',
    ];

    /**
     * Relasi ke User yang membuat lead ini
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke Project
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    /**
     * Relasi ke Customer
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * Status yang tersedia
     */
    public static function statuses(): array
    {
        return [
            'new' => 'New',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];
    }
}
