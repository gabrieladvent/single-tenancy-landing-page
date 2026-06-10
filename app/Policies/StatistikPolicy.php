<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Statistik;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatistikPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Statistik');
    }

    public function view(AuthUser $authUser, Statistik $statistik): bool
    {
        return $authUser->can('View:Statistik');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Statistik');
    }

    public function update(AuthUser $authUser, Statistik $statistik): bool
    {
        return $authUser->can('Update:Statistik');
    }

    public function delete(AuthUser $authUser, Statistik $statistik): bool
    {
        return $authUser->can('Delete:Statistik');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Statistik');
    }

    public function restore(AuthUser $authUser, Statistik $statistik): bool
    {
        return $authUser->can('Restore:Statistik');
    }

    public function forceDelete(AuthUser $authUser, Statistik $statistik): bool
    {
        return $authUser->can('ForceDelete:Statistik');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Statistik');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Statistik');
    }

    public function replicate(AuthUser $authUser, Statistik $statistik): bool
    {
        return $authUser->can('Replicate:Statistik');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Statistik');
    }

}