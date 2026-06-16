<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\VenueBooking;
use Illuminate\Auth\Access\HandlesAuthorization;

class VenueBookingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:VenueBooking');
    }

    public function view(AuthUser $authUser, VenueBooking $venueBooking): bool
    {
        return $authUser->can('View:VenueBooking');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:VenueBooking');
    }

    public function update(AuthUser $authUser, VenueBooking $venueBooking): bool
    {
        return $authUser->can('Update:VenueBooking');
    }

    public function delete(AuthUser $authUser, VenueBooking $venueBooking): bool
    {
        return $authUser->can('Delete:VenueBooking');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:VenueBooking');
    }

    public function restore(AuthUser $authUser, VenueBooking $venueBooking): bool
    {
        return $authUser->can('Restore:VenueBooking');
    }

    public function forceDelete(AuthUser $authUser, VenueBooking $venueBooking): bool
    {
        return $authUser->can('ForceDelete:VenueBooking');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:VenueBooking');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:VenueBooking');
    }

    public function replicate(AuthUser $authUser, VenueBooking $venueBooking): bool
    {
        return $authUser->can('Replicate:VenueBooking');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:VenueBooking');
    }

}