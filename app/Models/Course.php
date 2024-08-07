<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'courses';

    // Define which attributes are mass assignable
    protected $fillable = [
        'title',
        'description',
        'instructor_id',
        'category',
    ];

    // Define the relationship with the Instructor model
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
    // Define the relationship with the Student model
    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'course_id', 'student_id')
            ->withPivot('section_id'); // Include this if you have a pivot column named 'section_id'
    }
}
