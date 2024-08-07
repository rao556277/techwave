<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;  // Import the Course model if you need course-related data
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Show the student dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch student-specific data for the dashboard
        $user = Auth::user();  // Get the currently authenticated user
//        $enrolledCourses = $user->courses;  // Assuming a many-to-many relationship

        // You may also fetch other relevant data, such as:
        // $recentActivities = $user->activities()->latest()->take(5)->get();

        return view('student.dashboard', compact('user', ));
    }
}

