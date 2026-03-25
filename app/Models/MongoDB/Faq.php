<?php

namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];

    protected $casts = ['active' => 'boolean'];

    protected $table = 'faqs';
    protected $connection = 'mongodb';
    public $timestamps = true;

    public function getRouteKeyName()
    {
        return '_id';
    }
}