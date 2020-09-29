<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Tables\Traits\TableCache;
use LaravelEnso\Multitenancy\Traits\SystemConnection;

class Tree extends Model
{
	use TableCache;
	use SystemConnection;

    /**
     * @var array
     */
    protected $fillable = ['name', 'description','company_id','user_id'];
}
