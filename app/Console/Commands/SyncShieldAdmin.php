<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use ReflectionClass;

class SyncShieldAdmin extends Command
{
    protected $signature = 'shield:sync-admin';
    protected $description = 'Create Shield roles/permissions and assign super_admin to admin users';

    public function handle()
    {
        $guard = 'web';

        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => $guard]);

        $count = 0;
        foreach (User::where('role', 'admin')->get() as $user) {
            if (!$user->hasRole('super_admin')) {
                $user->assignRole('super_admin');
                $count++;
            }
        }

        return 0;
    }
}
