<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Matches;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatchesPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Matches');
    }

    public function view(AuthUser $authUser, Matches $matches): bool
    {
        return $authUser->can('View:Matches');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Matches');
    }

    public function update(AuthUser $authUser, Matches $matches): bool
    {
        return $authUser->can('Update:Matches');
    }

    public function delete(AuthUser $authUser, Matches $matches): bool
    {
        return $authUser->can('Delete:Matches');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Matches');
    }

    public function restore(AuthUser $authUser, Matches $matches): bool
    {
        return $authUser->can('Restore:Matches');
    }

    public function forceDelete(AuthUser $authUser, Matches $matches): bool
    {
        return $authUser->can('ForceDelete:Matches');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Matches');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Matches');
    }

    public function replicate(AuthUser $authUser, Matches $matches): bool
    {
        return $authUser->can('Replicate:Matches');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Matches');
    }

}