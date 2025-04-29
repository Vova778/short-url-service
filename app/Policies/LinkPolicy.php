<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Link;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any links (e.g. in index).
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the link.
     */
    public function view(User $user, Link $link)
    {
        return $user->id === $link->user_id;
    }

    /**
     * Determine whether the user can create links.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the link.
     */
    public function update(User $user, Link $link)
    {
        return $user->id === $link->user_id;
    }

    /**
     * Determine whether the user can delete the link.
     */
    public function delete(User $user, Link $link)
    {
        return $user->id === $link->user_id;
    }

    /**
     * Determine whether the user can restore the link.
     */
    public function restore(User $user, Link $link)
    {
        return $user->id === $link->user_id;
    }

    /**
     * Determine whether the user can permanently delete the link.
     */
    public function forceDelete(User $user, Link $link)
    {
        return $user->id === $link->user_id;
    }
}
