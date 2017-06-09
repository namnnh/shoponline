<?php

namespace App;

use Config;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct()
    {
        $this->table = Config::get('entrust.roles_table');
    }


    protected $fillable = ['name', 'display_name', 'description'];
}