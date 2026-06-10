<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Prestasi;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrestasiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Prestasi');
    }

    public function view(AuthUser $authUser, Prestasi $prestasi): bool
    {
        return $authUser->can('View:Prestasi');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Prestasi');
    }

    public function update(AuthUser $authUser, Prestasi $prestasi): bool
    {
        return $authUser->can('Update:Prestasi');
    }

    public function delete(AuthUser $authUser, Prestasi $prestasi): bool
    {
        return $authUser->can('Delete:Prestasi');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Prestasi');
    }

    public function restore(AuthUser $authUser, Prestasi $prestasi): bool
    {
        return $authUser->can('Restore:Prestasi');
    }

    public function forceDelete(AuthUser $authUser, Prestasi $prestasi): bool
    {
        return $authUser->can('ForceDelete:Prestasi');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Prestasi');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Prestasi');
    }

    public function replicate(AuthUser $authUser, Prestasi $prestasi): bool
    {
        return $authUser->can('Replicate:Prestasi');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Prestasi');
    }

}