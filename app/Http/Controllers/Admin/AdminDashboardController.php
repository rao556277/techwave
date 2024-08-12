<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Display a summary of the dashboard statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $totalInstructors = Instructor::count();
        $totalStudents = Student::count();
        $totalClasses = ClassModel::count();

        return response()->json([
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'totalEnrollments' => $totalEnrollments,
            'totalInstructors' => $totalInstructors,
            'totalStudents' => $totalStudents,
            'totalClasses' => $totalClasses,
        ]);
    }

    /**
     * Display the authenticated admin's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);

        return response()->json($user);
    }
}
