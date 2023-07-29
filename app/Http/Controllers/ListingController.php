<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*public function __construct()//this one of the authentication way
    {
        $this->middleware('auth')->except(['index', 'show']);
    }*/
    //Third Methods - useful for resource controller
    public function __construct()
    {
        $this->authorizeResource(Listing::class,'listing');//listing policy
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);
        //$query = Listing::orderByDesc('created_at');
        //Method 2
        /*$query->when(
            $filters['priceFrom'] ?? false,
            fn($query, $value) => $query->where('price', '>=', $value)
        )->when(
            $filters['priceTo'] ?? false,
            fn($query, $value) => $query->where('price', '>=', $value)
        )->when(
            $filters['beds'] ?? false,
            fn($query, $value) => $query->where('beds', (int)$value < 6 ? '=' : '>=', $value)
        )->when(
            $filters['baths'] ?? false,
            fn($query, $value) => $query->where('baths', (int)$value < 6 ? '=' : '>=', $value)
        )->when(
            $filters['areaFrom'] ?? false,
            fn($query, $value) => $query->where('area', '>=', $value)
        )->when(
            $filters['areaTo'] ?? false,
            fn($query, $value) => $query->where('area', '>=', $value)
        );*/

        //Method1
        /* if ($filters['priceFrom'] ?? false) {
            $query->where('price', '>=', $filters['priceFrom']);
        }

        if ($filters['priceTo'] ?? false) {
            $query->where('price', '<=', $filters['priceTo']);
        }

        if ($filters['beds'] ?? false) {
            $query->where('beds', $filters['beds']);
        }

        if ($filters['baths'] ?? false) {
            $query->where('baths', $filters['baths']);
        }

        if ($filters['areaFrom'] ?? false) {
            $query->where('area', '>=', $filters['areaFrom']);
        }

        if ($filters['areaTo'] ?? false) {
            $query->where('area', '<=', $filters['areaTo']);
        }*/

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,              //Methods 3
                'listings' => Listing::mostRecent() //refer to Listing model page of scopeMostRecent and scopeFilter methods
                    ->filter($filters)
                    ->withoutSold()
                    ->paginate(10) //pagination will return a pagination object
                    ->withQueryString() //will keep query data even open a new tab
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)//Laravel will instead fetch the model by the given ID from the route parameter and it will immediately get
    {
        //Auth::user()->can('view', $listing); //first par is function name of ListingPolicy , second is model
        //this only return true or false value even change to cannot

        /* if (Auth::user()->cannot('view', $listing)){ //but here we return abort for stopping controller
             abort(403);
         }*/

        //Another method:
        //$this->authorize('view', $listing);//it would check if the current user is authorized to perform this view operation on this model
        //and it will return 403
        $listing->load(['images']);//listing_images
        $offer = !Auth::user() ? null : $listing->offers()->byMe()->first();//return who made the listing offer
        return inertia(
            'Listing/Show',
            [
                //'listings' => Listing::find($id)
                'listing' => $listing,
                'offerMade' => $offer
                //we use another way that is route modal binding
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    /*public function destroy(Listing $listing)
    {
        $listing->delete();//this will remove data permanently -hard delete
        return redirect()->back()->with('success', 'Listing was deleted!');
        //but got thing called soft delete in laravel - let you just mark some of the records as deleted
        //but then eloquent would ignore those records by default when fetching data, but they are really sting in DB

    }*/
}
