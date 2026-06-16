<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Coach;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoachPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Coach');
    }

    public function view(AuthUser $authUser, Coach $coach): bool
    {
        return $authUser->can('View:Coach');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Coach');
    }

    public function update(AuthUser $authUser, Coach $coach): bool
    {
        return $authUser->can('Update:Coach');
    }

    public function delete(AuthUser $authUser, Coach $coach): bool
    {
        return $authUser->can('Delete:Coach');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Coach');
    }

    public function restore(AuthUser $authUser, Coach $coach): bool
    {
        return $authUser->can('Restore:Coach');
    }

    public function forceDelete(AuthUser $authUser, Coach $coach): bool
    {
        return $authUser->can('ForceDelete:Coach');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Coach');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Coach');
    }

    public function replicate(AuthUser $authUser, Coach $coach): bool
    {
        return $authUser->can('Replicate:Coach');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Coach');
    }

}