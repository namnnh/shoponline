<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Search\Searchable;

class Article extends Model
{
	use Searchable;
    protected $casts = [
    	'tags' => 'json',
    ];
}
