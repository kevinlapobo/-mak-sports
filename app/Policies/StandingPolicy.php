<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Standing;
use Illuminate\Auth\Access\HandlesAuthorization;

class StandingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Standing');
    }

    public function view(AuthUser $authUser, Standing $standing): bool
    {
        return $authUser->can('View:Standing');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Standing');
    }

    public function update(AuthUser $authUser, Standing $standing): bool
    {
        return $authUser->can('Update:Standing');
    }

    public function delete(AuthUser $authUser, Standing $standing): bool
    {
        return $authUser->can('Delete:Standing');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Standing');
    }

    public function restore(AuthUser $authUser, Standing $standing): bool
    {
        return $authUser->can('Restore:Standing');
    }

    public function forceDelete(AuthUser $authUser, Standing $standing): bool
    {
        return $authUser->can('ForceDelete:Standing');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Standing');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Standing');
    }

    public function replicate(AuthUser $authUser, Standing $standing): bool
    {
        return $authUser->can('Replicate:Standing');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Standing');
    }

}