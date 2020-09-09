<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    protected $table = 'history';
    protected $fillable = ['product_id', 'change_description'];
}
