<?php

namespace Bido\Category\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
//    protected $table='categories';
//
//    protected $fillable = ['title', 'slug', 'parent_id'];

    protected $guarded = [];

    public function getParentAttribute()
    {
        return is_null($this->parent_id)? '': $this->parentCategory->title;
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function subCategory()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}