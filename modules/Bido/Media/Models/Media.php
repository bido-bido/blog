<?php

namespace Bido\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Bido\Media\Services\MediaFileService;

class Media extends Model
{
    protected $table = 'media';

    protected $casts = [
        'files'=>'json'
    ];

    public function getThumbAttribute()
    {
        return '/storage/' . $this->files[300];
    }

    public static function booted()
    {
        static::deleting(function ($media){
            MediaFileService::delete($media);
        });
    }

}