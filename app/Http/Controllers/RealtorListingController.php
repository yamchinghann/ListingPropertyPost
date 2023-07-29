<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }
    //Auth::user() - why can ue this because user must authenticate before access index page
    //->listings - because user Model have listing function.
    public function index(Request $request)
    {
        //dd($request->all());
        //dd(Auth::user()->listings);
        //dd((bool)$request->boolean('deleted'));
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        return inertia('Realtor/Index',
            [
                'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filter($filters)
                    ->withCount('images')
                    ->withCount('offers')
                    ->paginate(5)
                    ->withQueryString() //return pagination object
            ]
        );
    }

    public function show(Listing $listing)
    {
        return inertia(
            'Realtor/Show',
            ['listing' => $listing->load('offers', 'offers.bidder')] //listing + related offers
        //want offer.bidder **nested
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //return and render create form
    {
        //$this->authorize('create', Listing::class);
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    //we can quickly get current user
    //Auth::user() or $request->user();
    //$request->user()->listings()->create //create new listing associate with the user
    public function store(Request $request)
    {
        //dd($request->all());
        //dd($request->beds);
        //we can do that but more waste time, so we can another methods
        /*$listing = new Listing();
        $listing->beds = $request->beds;
        $listing->save();*/
        //Method 2 -Listing::created()
        /* Listing::create(
            // ...$request->all(),//...array merge function which allow you to merge two array function
             $request->validate([
                 'beds' => 'required|integer|min:0|max:20', //all error messages will handle by inertia middleware,
                 'baths' => 'required|integer|min:0|max:20',
                 'area' => 'required|integer|min:15|max:1500',
                 'city' => 'required',
                 'code' => 'required',
                 'street' => 'required',
                 'street_nr' => 'required|min:1|max:1000',
                 'price' => 'required|integer|min:1|max:20000000',
             ])
         );*/
        $request->user()->listings()->create(//here no need to check authenticate as web.php have check for it with auth.
            $request->validate([
                'beds' => 'required|integer|min:0|max:20', //all error messages will handle by inertia middleware,
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
            ]));

        return redirect()->route('realtor.listing.index')->with('success', 'Listing was created');//flash message

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing) //this one would be responsible for rendering the edit form
    {
        return inertia(
            'Realtor/Edit',
            [
                //'listings' => Listing::find($id)
                'listing' => $listing
                //we use another way that is route modal binding
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)//this one for accepting the send input and then updating the existing listing
    {
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20', //can use these variable easily because of fillable in listing model
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );
        return redirect()->route('realtor.listing.index')->with('success', 'Listing was updated');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();//this will be soft delete as Listing model had set SoftDelete Mode
        //deleteOrFail will if the mode exist then delete. if the model is not exist then it throws an error about can't to delete
        return redirect()->back()->with('success', 'Listing was deleted!');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()->with('success', 'Listing was restored!');
    }
}
