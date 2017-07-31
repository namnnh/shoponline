<?php
namespace App\Repositories\Category;

use App\Category;

class EloquentCategory implements CategoryRepository
{
    public function paginate($perPage, $search = null)
    {
        $query = Category::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', "like", "%{$search}%");
            });
        }

        $result = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;
    }

    public function all()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function lists ($column = 'name', $key = 'id')
    {
        return Category::orderBy('name')->pluck($column,$key);
    }

    public function listsExpectItself ($expect, $column = 'name', $key = 'id')
    {
        return Category::where('id','!=',$expect)->orderBy('name')->pluck($column,$key);
    }

    public function create (array $data)
    {
         if (! array_get($data, 'parent_id')) {
            $data['parent_id'] = null;
        }
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        if (! array_get($data, 'parent_id')) {
            $data['parent_id'] = null;
        }
        $category = $this->find($id);

        $category->update($data);

        return $category;
    }
}