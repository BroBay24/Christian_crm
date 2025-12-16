<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
