<?php

namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MySQL\Sitemap;

class Game extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'games';

    protected $primaryKey = '_id';
    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = true;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return '_id';
    }

    public function sitemap()
    {
        return $this->hasOne(Sitemap::class, 'entity_id')->where('entity', 'games');
    }
}
