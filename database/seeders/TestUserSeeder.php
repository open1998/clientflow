<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the test user
        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Ensure the user has a workspace
        if ($user->ownedWorkspaces()->count() === 0) {
            $workspace = Workspace::create([
                'name' => 'Test Agency',
                'slug' => 'test-agency',
                'owner_id' => $user->id,
                'currency' => 'USD',
                'timezone' => 'UTC',
            ]);

            // Link user to workspace in pivot table
            $user->workspaces()->syncWithoutDetaching([
                $workspace->id => ['role' => 'owner'],
            ]);
        }

        echo "Test user and workspace created successfully.\n";
    }
}
