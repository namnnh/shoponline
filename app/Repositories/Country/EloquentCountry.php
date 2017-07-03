<?php

namespace App\Repositories\Country;

use App\Country;

class EloquentCountry implements CountryRepository
{
    public function lists ($column = 'name' , $key = 'id')
    {
        return Country::orderBy('name')->pluck($column,$key);
    }
}