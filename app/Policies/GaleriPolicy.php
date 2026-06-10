<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Galeri;
use Illuminate\Auth\Access\HandlesAuthorization;

class GaleriPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Galeri');
    }

    public function view(AuthUser $authUser, Galeri $galeri): bool
    {
        return $authUser->can('View:Galeri');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Galeri');
    }

    public function update(AuthUser $authUser, Galeri $galeri): bool
    {
        return $authUser->can('Update:Galeri');
    }

    public function delete(AuthUser $authUser, Galeri $galeri): bool
    {
        return $authUser->can('Delete:Galeri');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Galeri');
    }

    public function restore(AuthUser $authUser, Galeri $galeri): bool
    {
        return $authUser->can('Restore:Galeri');
    }

    public function forceDelete(AuthUser $authUser, Galeri $galeri): bool
    {
        return $authUser->can('ForceDelete:Galeri');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Galeri');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Galeri');
    }

    public function replicate(AuthUser $authUser, Galeri $galeri): bool
    {
        return $authUser->can('Replicate:Galeri');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Galeri');
    }

}