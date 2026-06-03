<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceSetting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'template_theme',
        'primary_color',
        'studio_logo',
        'payment_terms',
    ];

    /**
     * User pemilik pengaturan invoice ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
