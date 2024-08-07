<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class InstructorStudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $instructorId = Auth::user()->id;
        $courses = Course::where('instructor_id', $instructorId)->get();
        $students = Student::whereHas('courses', function($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })->get();

        return view('instructor.students.index', compact('students', 'courses'));
    }

    /**
     * Show the details of a specific student.
     *
     * @param int $studentId
     * @return \Illuminate\View\View
     */
    public function show($studentId)
    {
        $student = Student::findOrFail($studentId);
        $courses = $student->courses()->where('instructor_id', Auth::user()->id)->get();

        return view('instructor.students.show', compact('student', 'courses'));
    }
}
