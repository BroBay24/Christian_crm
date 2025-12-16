<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $fillable = [
        'lead_id',
        'approved_by',
        'status',
        'approved_date',
    ];

    protected $casts = [
        'approved_date' => 'date',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'lead_id', 'lead_id');
    }

    public static function statuses(): array
    {
        return [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ];
    }
}
