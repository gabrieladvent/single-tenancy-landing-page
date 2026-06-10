<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Fasilitas;
use Illuminate\Auth\Access\HandlesAuthorization;

class FasilitasPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Fasilitas');
    }

    public function view(AuthUser $authUser, Fasilitas $fasilitas): bool
    {
        return $authUser->can('View:Fasilitas');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Fasilitas');
    }

    public function update(AuthUser $authUser, Fasilitas $fasilitas): bool
    {
        return $authUser->can('Update:Fasilitas');
    }

    public function delete(AuthUser $authUser, Fasilitas $fasilitas): bool
    {
        return $authUser->can('Delete:Fasilitas');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Fasilitas');
    }

    public function restore(AuthUser $authUser, Fasilitas $fasilitas): bool
    {
        return $authUser->can('Restore:Fasilitas');
    }

    public function forceDelete(AuthUser $authUser, Fasilitas $fasilitas): bool
    {
        return $authUser->can('ForceDelete:Fasilitas');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Fasilitas');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Fasilitas');
    }

    public function replicate(AuthUser $authUser, Fasilitas $fasilitas): bool
    {
        return $authUser->can('Replicate:Fasilitas');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Fasilitas');
    }

}