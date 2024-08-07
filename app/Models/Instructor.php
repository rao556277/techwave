<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $table = 'instructors';
    protected $fillable = [
        'first_name',
        'last_name',
        'contact',
        'email',
        'password',
        'cnic',
        'bio',
        'image',
        'user_id'
        ];

}
