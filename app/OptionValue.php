<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Option;

class OptionValue extends Model
{
    protected $table = 'option_value';

    public $timestamps = false;

    protected $fillable = ['name', 'sort_order'];
}
