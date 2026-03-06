<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecretNote extends Model
{
    protected $fillable = ['content', 'category', 'is_active'];
}
