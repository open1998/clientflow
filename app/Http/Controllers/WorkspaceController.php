<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Support\Facades\Session;

class WorkspaceController extends Controller
{
    /**
     * Switch the active workspace.
     */
    public function switch(Workspace $workspace)
    {
        // Ensure the user belongs to this workspace
        if (! auth()->user()->workspaces->contains($workspace->id)) {
            abort(403);
        }

        Session::put('workspace_id', $workspace->id);

        return redirect()->route('dashboard');
    }

    /**
     * Show the workspace creation page.
     */
    public function create()
    {
        return view('workspaces.create');
    }
}
