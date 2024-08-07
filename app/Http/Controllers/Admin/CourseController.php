<?php
//
//namespace App\Http\Controllers\Admin;
//
//use App\Http\Controllers\Controller;
//use App\Models\Course;
//use App\Models\Instructor;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
//
//
//class CourseController extends Controller
//{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\View\View
//     */
//    public function index()
//    {
//        $courses = Course::with('instructor')->get();
//
//        //        dd($courses);
//        return view('admin.courses.index', compact('courses'));
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\View\View
//     */
//    public function create()
//    {
//        $instructors = Instructor::all();
//        return view('admin.courses.create', compact('instructors'));
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'title' => 'required|string|max:255',
//            'description' => 'required|string',
//            // Add other validation rules as needed
//        ]);
//        $course = new Course();
//        $course->title = $request->title;
//        $course->description = $request->description;
//        $course->instructor_id = $request->instructor_id;
//        $course->save();
//
//        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\View\View
//     */
//    public function show(Course $course)
//    {
//        return view('admin.courses.show', compact('course'));
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\View\View
//     */
//    public function edit(Course $course)
//    {
//        $instructors = Instructor::all();
//        return view('admin.courses.edit', compact('course', 'instructors'));
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    //    public function update(Request $request, Course $course)
////    {
////        $request->validate([
////            'title' => 'required|string|max:255',
////            'description' => 'required|string',
////            // Add other validation rules as needed
////        ]);
////
////        $course->title = $request->title;
////        $course->description = $request->description;
////        // Update other fields as needed
////
////        $course->save();
////
////        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
////    }
//    public function update(Request $request, Course $course)
//    {
//        // Validate the request data
//        $validator = Validator::make($request->all(), [
//            'title' => 'required|string|max:255',
//            'description' => 'required|string',
//            'instructor_id' => 'required|exists:instructors,id',
//            'category' => 'required|string|max:255',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->route('courses.edit', $course->id)
//                ->withErrors($validator)
//                ->withInput();
//        }
//
//        // Find the course by its ID
//        $course = Course::findOrFail($course->id);
//
//        // Update the course with validated data
//        $course->update([
//            'title' => $request->title,
//            'description' => $request->description,
//            'instructor_id' => $request->instructor_id,
//            'category' => $request->category,
//        ]);
//
//        // Redirect back to the course index with a success message
//        return redirect()->route('admin.courses.index')
//            ->with('success', 'Course updated successfully.');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Models\Course  $course
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function destroy(Course $course)
//    {
//        $course->delete();
//        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
//    }
//}



// app/Http/Controllers/Admin/CourseController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')->get();
        return response()->json($courses, 200);
    }

    public function create()
    {
        $instructors = Instructor::all();
        return response()->json($instructors, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructor_id' => $request->instructor_id,
        ]);

        return response()->json($course, 201);
    }

    public function show(Course $course)
    {
        return response()->json($course, 200);
    }

    public function edit(Course $course)
    {
        $instructors = Instructor::all();
        return response()->json(['course' => $course, 'instructors' => $instructors], 200);
    }

    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
            'category' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'instructor_id' => $request->instructor_id,
            'category' => $request->category,
        ]);

        return response()->json($course, 200);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(null, 204);
    }
}
