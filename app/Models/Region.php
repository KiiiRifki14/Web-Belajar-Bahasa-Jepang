<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'order', 'description'];

    public function levels()
    {
        return $this->hasMany(Level::class)->orderBy('order');
    }
}
