<?php

namespace App\Repositories\Option;

use App\Category;

interface OptionRepository
{
    public function paginate($perPage, $search = null);

    // public function all();

    // public function lists ($column = 'name', $key = 'id');

    public function create (array $data);

    // public function listsExpectItself ($expect , $column = 'name', $key = 'id');

    public function update($id, array $data);
}