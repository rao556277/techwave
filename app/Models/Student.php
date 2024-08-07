<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['class_id','first_name','last_name','contact','cnic','email','password','bio','image'];
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id');
    }
}
