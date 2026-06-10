<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Halaman;
use Illuminate\Auth\Access\HandlesAuthorization;

class HalamanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Halaman');
    }

    public function view(AuthUser $authUser, Halaman $halaman): bool
    {
        return $authUser->can('View:Halaman');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Halaman');
    }

    public function update(AuthUser $authUser, Halaman $halaman): bool
    {
        return $authUser->can('Update:Halaman');
    }

    public function delete(AuthUser $authUser, Halaman $halaman): bool
    {
        return $authUser->can('Delete:Halaman');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Halaman');
    }

    public function restore(AuthUser $authUser, Halaman $halaman): bool
    {
        return $authUser->can('Restore:Halaman');
    }

    public function forceDelete(AuthUser $authUser, Halaman $halaman): bool
    {
        return $authUser->can('ForceDelete:Halaman');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Halaman');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Halaman');
    }

    public function replicate(AuthUser $authUser, Halaman $halaman): bool
    {
        return $authUser->can('Replicate:Halaman');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Halaman');
    }

}