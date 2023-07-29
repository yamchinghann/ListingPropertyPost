<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
    public function before(?User $user, $ability){//override every possible action
        if($user?->is_admin){ //if the user is admin then he can do anything
            return true;//if you logout then will get this error "Attempt to read property "is_admin" on null" so need add ? after
        }
        /*if($user->is_admin && $ability === 'update'){ //only allow admin able to update in any listing
            return true;
        }*/
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool //access index file
        //? - if the user return null mean unauthorized/unregistered user can access whenever the method is set to true or false
    {
       return true; //false will unauthenticated
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listing $listing): bool //we can change the function name to xxx but in listing model need to use the name accurately
    {
        if ($listing->by_user_id === $user?->id) { //only able to see the listing that is equal current user id
            return true;
        }

        return $listing->sold_at === null; //only can see those listing is not sold
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): bool
    {
        return $listing->sold_at === null
        && ($user->id === $listing->by_user_id);//rule means that the only people who can modify a
        // listing are the people who have created //other word->current user id must same with the listing Fk user_id
        //so you cannot CRUD other user listing.
        //able to modify those not sold listing item.
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
        //return $user->id === $listing->by_user_id || $user->is_admin; //mean either equal to FK user id or user is admin
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }
}
