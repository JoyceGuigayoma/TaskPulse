<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Demo Users
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@taskpulse.com'],
            [
                'name' => 'Alex Admin',
                'password' => Hash::make('password123'),
            ]
        );

        $managerUser = User::firstOrCreate(
            ['email' => 'manager@taskpulse.com'],
            [
                'name' => 'Morgan Manager',
                'password' => Hash::make('password123'),
            ]
        );

        $memberUser = User::firstOrCreate(
            ['email' => 'member@taskpulse.com'],
            [
                'name' => 'Sam Member',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Create Workspace 1: Acme Corp
        $acmeWorkspace = Workspace::firstOrCreate(
            ['slug' => 'acme-corp'],
            [
                'owner_id' => $adminUser->id,
                'name' => 'Acme Corp',
            ]
        );

        // Attach Members with Roles to Acme Corp
        $acmeWorkspace->members()->syncWithoutDetaching([
            $adminUser->id => ['role' => 'admin'],
            $managerUser->id => ['role' => 'manager'],
            $memberUser->id => ['role' => 'member'],
        ]);

        // Create Sample Projects for Acme Corp
        Project::firstOrCreate(
            ['workspace_id' => $acmeWorkspace->id, 'title' => 'Redesign Marketing Landing Page'],
            [
                'description' => 'Update the homepage with modern Tailwind components and fast asset loading.',
                'status' => 'completed',
            ]
        );

        Project::firstOrCreate(
            ['workspace_id' => $acmeWorkspace->id, 'title' => 'Stripe Billing Integration'],
            [
                'description' => 'Implement Laravel Cashier webhooks for subscription cancellation and upgrades.',
                'status' => 'in_progress',
            ]
        );

        Project::firstOrCreate(
            ['workspace_id' => $acmeWorkspace->id, 'title' => 'Setup CI/CD Pipeline'],
            [
                'description' => 'Automate testing and deployment using GitHub Actions.',
                'status' => 'pending',
            ]
        );

        // 3. Create Workspace 2: Stark Industries
        $starkWorkspace = Workspace::firstOrCreate(
            ['slug' => 'stark-industries'],
            [
                'owner_id' => $managerUser->id,
                'name' => 'Stark Industries',
            ]
        );

        // Attach Members with Roles to Stark Industries
        $starkWorkspace->members()->syncWithoutDetaching([
            $managerUser->id => ['role' => 'admin'],
            $memberUser->id => ['role' => 'manager'],
        ]);

        // Create Sample Projects for Stark Industries
        Project::firstOrCreate(
            ['workspace_id' => $starkWorkspace->id, 'title' => 'Arc Reactor Firmware Update'],
            [
                'description' => 'Refactor telemetry logging and real-time monitoring dashboard.',
                'status' => 'in_progress',
            ]
        );

        Project::firstOrCreate(
            ['workspace_id' => $starkWorkspace->id, 'title' => 'AI Assistant API Optimization'],
            [
                'description' => 'Reduce latency on context retrieval endpoints.',
                'status' => 'pending',
            ]
        );

        $this->command->info('Database seeded successfully with demo accounts!');
    }
}