<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin
        {email : Admin email address}
        {--name=Facility Manager : Full name}
        {--password=admin123 : Login password}
        {--role=facility_manager : User role}';

    protected $description = 'Create an admin/facility manager user';

    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->option('name');
        $password = $this->option('password');
        $role = $this->option('role');

        if (User::where('email', $email)->exists()) {
            $this->error("User with email '{$email}' already exists!");
            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'full_name' => $name,
            'status' => 'approved',
        ]);

        $this->info("✅ {$role} user '{$name}' created!");
        $this->warn("   Email: {$email}");
        $this->warn("   Password: {$password}");

        return 0;
    }
}
