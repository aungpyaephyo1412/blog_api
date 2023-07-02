<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $slug)
 */
class Blogs extends Model
{
    use HasFactory;
    protected $hidden = ['user_id'];
}
