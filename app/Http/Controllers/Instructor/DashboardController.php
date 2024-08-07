<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Student;
class DashboardController extends Controller
{
    /**
     * Display the instructor's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        $userId = auth()->user()->id; // Assuming the instructor is authenticated
        $instructor = Instructor::where('user_id', $userId)->firstOrFail();
        $instructorId = $instructor->id;
        $courses = Course::where('instructor_id', $instructorId)->get();
        return view('instructor.dashboard', compact('instructor', 'courses'));
    }


    /**
     * Show the instructor's profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $userId = auth()->user()->id; // Assuming the instructor is authenticated
        $instructor = Instructor::where('user_id', $userId)->firstOrFail();

        return view('instructor.profile', compact('instructor'));
    }

    /**
     * Update the instructor's profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $userId = auth()->user()->id; // Assuming the instructor is authenticated
        $instructor = Instructor::where('user_id', $userId)->firstOrFail();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $instructor->update($request->only('first_name', 'last_name', 'email', 'contact', 'bio'));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('instructors', 'public');
            $instructor->update(['image' => $imagePath]);
        }

        return redirect()->route('instructor.profile')->with('success', 'Profile updated successfully.');
    }
}
