<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class InstructorReportController extends Controller
{
    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $instructorId = Auth::user()->id;
        $courses = Course::where('instructor_id', $instructorId)->get();

        // Example: Aggregate data for reports
        $reports = $this->generateReports($courses);

        return view('instructor.reports.index', compact('reports', 'courses'));
    }

    /**
     * Generate reports for the given courses.
     *
     * @param \Illuminate\Support\Collection $courses
     * @return array
     */
    protected function generateReports($courses)
    {
        $reports = [];

        foreach ($courses as $course) {
            $studentCount = $course->students()->count();
            $averageGrade = $course->students()->avg('pivot.grade'); // Assuming there's a grade field in the pivot table

            $reports[] = [
                'course' => $course,
                'student_count' => $studentCount,
                'average_grade' => $averageGrade,
            ];
        }

        return $reports;
    }

    /**
     * Show detailed report for a specific course.
     *
     * @param int $courseId
     * @return \Illuminate\View\View
     */
    public function show($courseId)
    {
        $course = Course::findOrFail($courseId);
        $students = $course->students;

        return view('instructor.reports.show', compact('course', 'students'));
    }

    /**
     * Filter reports based on request parameters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $instructorId = Auth::user()->id;
        $courses = Course::where('instructor_id', $instructorId)
            ->when($request->course_id, function ($query) use ($request) {
                $query->where('id', $request->course_id);
            })
            ->get();

        $reports = $this->generateReports($courses);

        return view('instructor.reports.index', compact('reports', 'courses'));
    }
}
