<?php

namespace App\Models;

use App\Traits\ClientScoped;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasUuids, SoftDeletes, Tenantable, ClientScoped;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workspace_id',
        'client_id',
        'name',
        'amount',
        'currency',
        'interval',
        'status',
        'started_at',
        'next_billing_at',
        'metadata',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'next_billing_at' => 'date',
            'metadata' => 'array',
        ];
    }

    /**
     * Get the client that owns the subscription.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the invoices for the subscription.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
