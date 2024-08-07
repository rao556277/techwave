<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = auth()->user()->id; // Assuming the instructor is authenticated
        $instructor = Instructor::where('user_id', $userId)->firstOrFail();
        $instructorId = $instructor->id;
        $courses = Course::where('instructor_id', auth()->user()->id)->get();
        return view('instructor.courses.index', compact('instructor','courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('instructor.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            // Add other validation rules as needed
        ]);

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->instructor_id = auth()->user()->id;
        // Set other fields as needed

        $course->save();

        return redirect()->route('instructor.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\View\View
     */
    public function show(Course $course)
    {
        $this->authorize('view', $course);
        return view('instructor.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\View\View
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('instructor.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            // Add other validation rules as needed
        ]);

        $this->authorize('update', $course);

        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        // Update other fields as needed

        $course->save();

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully.');
    }
}
