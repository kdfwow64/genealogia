<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelEnso\Tables\Traits\TableCache;
use LaravelEnso\Multitenancy\Traits\SystemConnection;


class Tree extends Model
{
	use TableCache;
	use SystemConnection;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name', 'description','company_id','user_id'];
}
