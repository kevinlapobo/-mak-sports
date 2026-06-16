<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MatchEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatchEventPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MatchEvent');
    }

    public function view(AuthUser $authUser, MatchEvent $matchEvent): bool
    {
        return $authUser->can('View:MatchEvent');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MatchEvent');
    }

    public function update(AuthUser $authUser, MatchEvent $matchEvent): bool
    {
        return $authUser->can('Update:MatchEvent');
    }

    public function delete(AuthUser $authUser, MatchEvent $matchEvent): bool
    {
        return $authUser->can('Delete:MatchEvent');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MatchEvent');
    }

    public function restore(AuthUser $authUser, MatchEvent $matchEvent): bool
    {
        return $authUser->can('Restore:MatchEvent');
    }

    public function forceDelete(AuthUser $authUser, MatchEvent $matchEvent): bool
    {
        return $authUser->can('ForceDelete:MatchEvent');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MatchEvent');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MatchEvent');
    }

    public function replicate(AuthUser $authUser, MatchEvent $matchEvent): bool
    {
        return $authUser->can('Replicate:MatchEvent');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MatchEvent');
    }

}