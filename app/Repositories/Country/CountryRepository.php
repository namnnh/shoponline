<?php

namespace App\Repositories\Country;

interface CountryRepository
{
    public function lists ($coulumn = 'name', $key = 'id');
}