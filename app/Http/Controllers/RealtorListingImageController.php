<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing){
        $listing->load(['images']); //it will load all related images at Listing table
        return inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }

    public function store(Listing $listing, Request $request){
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'mimes:jpg,png,jpeg,webp|max:5000' //it will validate single image in array images
            ], [
                'images.*.mimes' => 'The file should be in one of the formats: jpg, png, jpeg, webp'
            ]);//second parm is customer validation message

            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');//store in images folder at root directory of public

                $listing->images()->save(new ListingImage([
                    'filename' => $path
                ]));
            }
        }

        return redirect()->back()->with('success', 'Images uploaded!');
    }

    public function destroy(Listing $listing, ListingImage $image){
        Storage::disk('public')->delete($image->filename);//it allows you to access default disk or specific disk, the default disk is FILESYSTEM_DISK**local in filesystems.php
        $image->delete();

        return redirect()->back()->with('success', 'Image was deleted');
    }
}
