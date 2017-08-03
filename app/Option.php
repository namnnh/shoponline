<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OptionValue;

class Option extends Model
{
    protected $table = 'option';
    protected $fillable = ['name', 'type', 'sort_order'];
    public $timestamps = false;

    public function optionValues()
    {
    	return $this->hasMany(OptionValue::class);
    }
}