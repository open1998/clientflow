<?php

namespace App\Traits;

use App\Models\Workspace;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Tenantable
{
    /**
     * Boot the trait.
     */
    protected static function bootTenantable(): void
    {
        static::creating(function ($model) {
            if (empty($model->workspace_id) && session()->has('workspace_id')) {
                $model->workspace_id = session()->get('workspace_id');
            }
        });

        static::addGlobalScope('workspace', function (Builder $builder) {
            if (session()->has('workspace_id')) {
                $builder->where('workspace_id', session()->get('workspace_id'));
            }
        });
    }

    /**
     * Get the workspace that owns the model.
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }
}
