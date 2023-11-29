<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserWidget;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserWidgetPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, UserWidget $userWidget): bool
    {
        return $userWidget->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->userWidgets()->count() < 5;
    }

    public function update(User $user, UserWidget $userWidget): bool
    {
        return $userWidget->user_id === $user->id;
    }

    public function delete(User $user, UserWidget $userWidget): bool
    {
        return $userWidget->user_id === $user->id;
    }

    public function restore(User $user, UserWidget $userWidget): bool
    {
        return $userWidget->user_id === $user->id;
    }

    public function forceDelete(User $user, UserWidget $userWidget): bool
    {
        return $userWidget->user_id === $user->id;
    }
}
