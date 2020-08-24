<?php

namespace Bido\Category\Repositories;

use Bido\Category\Models\Category;

class CategoryRepo
{
    public function all()
    {
        return Category::all();
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function allExceptById($id)
    {
//        return Category::where('id', '!=', $category->id)->get();
        return $this->all()->filter(function ($item) use ($id) {
            return $item->id != $id;
        });
    }

    public function store($values)
    {
        return Category::create([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,
        ]);
    }

    public function update($id, $values)
    {
        return Category::query()->where('id', $id)->update([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,
        ]);
    }

    public function delete($id)
    {
        Category::where('id', $id)->delete();

    }
}