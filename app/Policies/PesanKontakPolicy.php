<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PesanKontak;
use Illuminate\Auth\Access\HandlesAuthorization;

class PesanKontakPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PesanKontak');
    }

    public function view(AuthUser $authUser, PesanKontak $pesanKontak): bool
    {
        return $authUser->can('View:PesanKontak');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PesanKontak');
    }

    public function update(AuthUser $authUser, PesanKontak $pesanKontak): bool
    {
        return $authUser->can('Update:PesanKontak');
    }

    public function delete(AuthUser $authUser, PesanKontak $pesanKontak): bool
    {
        return $authUser->can('Delete:PesanKontak');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PesanKontak');
    }

    public function restore(AuthUser $authUser, PesanKontak $pesanKontak): bool
    {
        return $authUser->can('Restore:PesanKontak');
    }

    public function forceDelete(AuthUser $authUser, PesanKontak $pesanKontak): bool
    {
        return $authUser->can('ForceDelete:PesanKontak');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PesanKontak');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PesanKontak');
    }

    public function replicate(AuthUser $authUser, PesanKontak $pesanKontak): bool
    {
        return $authUser->can('Replicate:PesanKontak');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PesanKontak');
    }

}