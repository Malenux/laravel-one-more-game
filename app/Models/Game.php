<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sitemap;

class Game extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function sitemap()
    {
        return $this->hasOne(Sitemap::class, 'entity_id')->where('entity', 'games');
    }
}