<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class RealtorListingAcceptOfferController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Offer $offer)//it will called as function
    {
        $listing = $offer->listing;
        $this->authorize('update', $listing);
        // Accept selected offer
        $offer->update(['accepted_at' => now()]);//use update function must make sure accepted_at have placed at fillable fill

        $listing->sold_at = now();
        $listing->save();

        // Reject all other offers
        $offer->listing->offers()->except($offer)//$offer->listing - will get associate listing offer
            //offers->will get all offers with the listing
            //and reject those not equal to current offer id
            ->update(['rejected_at' => now()]);

        return redirect()->back()->with('success', "Offer #{$offer->id}, other offers rejected");
    }
}
