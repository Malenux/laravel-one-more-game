<?php

namespace App\Models\MongoDB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MySQL\Sitemap;

class Platform extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'mongodb';
    protected $table = 'platforms';
    protected $primaryKey = '_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public function getKeyName()
    {
        return '_id';
    }

    public function sitemap()
    {
        return $this->hasOne(Sitemap::class, 'entity_id')->where('entity', 'platforms');
    }
}