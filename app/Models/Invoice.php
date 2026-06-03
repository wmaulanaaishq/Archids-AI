<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'invoice_number',
        'termin_name',
        'percentage',
        'amount',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
            'amount'     => 'integer',
        ];
    }

    /**
     * Proyek yang terkait dengan invoice ini.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
