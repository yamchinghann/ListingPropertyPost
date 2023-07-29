<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename'
    ];
    protected $appends = ['src']; //we not only create getSrcAttribute to product URL,
    // and we also need to append produced URL to src attribute

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
        //we didn't specific column name for FK name then no need put.
    }
   //getRealSrcAttribute -> convert to real_src
    public function getSrcAttribute(){
        return asset("storage/{$this->filename}"); //going to produce the URL relative to storage folder using this filename
    }


}
