<?php

namespace App\Traits;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;

trait ClientScoped
{
    /**
     * Boot the trait.
     */
    protected static function bootClientScoped(): void
    {
        static::addGlobalScope('client_access', function (Builder $builder) {
            if (app()->runningInConsole()) {
                return;
            }

            $user = auth()->user();
            $workspaceId = session('workspace_id');

            if ($user && $workspaceId) {
                // Check if the user is a 'client' in this workspace
                $workspaceUser = $user->workspaces()
                    ->where('workspaces.id', $workspaceId)
                    ->first()?->pivot;

                if ($workspaceUser && $workspaceUser->role === 'client') {
                    // Find the client record for this user in this workspace
                    $client = Client::where('workspace_id', $workspaceId)
                        ->where('user_id', $user->id)
                        ->first();

                    if ($client) {
                        $builder->where($builder->getModel()->getTable() . '.client_id', $client->id);
                    } else {
                        // If role is client but no record exists, deny all access
                        $builder->whereRaw('1 = 0');
                    }
                }
            }
        });
    }
}
