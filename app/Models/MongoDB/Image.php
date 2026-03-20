<?php

namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $table = 'images';
    protected $connection = 'mongodb';
    public $timestamps = true;

    public function getRouteKeyName()
    {
        return '_id';
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
