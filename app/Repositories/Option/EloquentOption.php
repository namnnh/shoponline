<?php
namespace App\Repositories\Option;

use App\Option;
use DB;

class EloquentOption implements OptionRepository
{
    public function paginate($perPage, $search = null)
    {
        $query = Option::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', "like", "%{$search}%");
            });
        }

        $result = $query->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;
    }

    // public function all()
    // {
    //     return Category::all();
    // }

    // public function find($id)
    // {
    //     return Category::find($id);
    // }

    // public function lists ($column = 'name', $key = 'id')
    // {
    //     return Category::orderBy('name')->pluck($column,$key);
    // }

    // public function listsExpectItself ($expect, $column = 'name', $key = 'id')
    // {
    //     return Category::where('id','!=',$expect)->orderBy('name')->pluck($column,$key);
    // }

    public function create (array $data)
    {
        $option_value = $data['option_value'];
        unset($data['option_value']);
        DB::transaction(function () use($data,$option_value) {
            $option = Option::create($data);
            $option->optionValues()->createMany($option_value);
            if( !$option )
            {
                throw new \Exception('User not created for account');
            }
        });
        return $option;
    }

    public function update($id, array $data)
    {
        $option_value = $data['option_value'];
        unset($data['option_value']);

        $option = Option::find($id);

        $option->update($data);

        $option->optionValues()->saveMany($option_value);

        return $option;
    }
}