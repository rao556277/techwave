<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Instructor;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a list of classes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classes = ClassModel::all();
        return response()->json($classes);
    }

    /**
     * Store a newly created class in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        $class = ClassModel::create($request->all());
        return response()->json(['success' => 'Class created successfully.', 'class' => $class], 201);
    }

    /**
     * Display the specified class.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $class = ClassModel::findOrFail($id);
        $students = Student::all(); // Or a specific list of students related to this class
        return response()->json(['class' => $class, 'students' => $students]);
    }

    /**
     * Add a student to a class.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addStudent(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $class = ClassModel::findOrFail($id);
        $student = Student::findOrFail($request->student_id);
        $class->students()->attach($student);

        return response()->json(['success' => 'Student added to class successfully.']);
    }

    /**
     * Update the specified class.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $class = ClassModel::findOrFail($id);
        $class->update($request->all());

        return response()->json(['success' => 'Class updated successfully.', 'class' => $class]);
    }

    /**
     * Remove the specified class from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return response()->json(['success' => 'Class deleted successfully.']);
    }
}
