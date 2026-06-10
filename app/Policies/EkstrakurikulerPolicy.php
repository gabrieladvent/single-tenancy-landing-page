<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Ekstrakurikuler;
use Illuminate\Auth\Access\HandlesAuthorization;

class EkstrakurikulerPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Ekstrakurikuler');
    }

    public function view(AuthUser $authUser, Ekstrakurikuler $ekstrakurikuler): bool
    {
        return $authUser->can('View:Ekstrakurikuler');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Ekstrakurikuler');
    }

    public function update(AuthUser $authUser, Ekstrakurikuler $ekstrakurikuler): bool
    {
        return $authUser->can('Update:Ekstrakurikuler');
    }

    public function delete(AuthUser $authUser, Ekstrakurikuler $ekstrakurikuler): bool
    {
        return $authUser->can('Delete:Ekstrakurikuler');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Ekstrakurikuler');
    }

    public function restore(AuthUser $authUser, Ekstrakurikuler $ekstrakurikuler): bool
    {
        return $authUser->can('Restore:Ekstrakurikuler');
    }

    public function forceDelete(AuthUser $authUser, Ekstrakurikuler $ekstrakurikuler): bool
    {
        return $authUser->can('ForceDelete:Ekstrakurikuler');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Ekstrakurikuler');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Ekstrakurikuler');
    }

    public function replicate(AuthUser $authUser, Ekstrakurikuler $ekstrakurikuler): bool
    {
        return $authUser->can('Replicate:Ekstrakurikuler');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Ekstrakurikuler');
    }

}