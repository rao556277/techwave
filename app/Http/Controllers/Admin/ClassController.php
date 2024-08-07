<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $instructors = Instructor::all();
        return view('admin.classes.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

        ]);
        $class = new ClassModel();
        $class->name = $request->name;
        //dd($request->all());
        $class->description = $request->description;
        $class->instructor_id = $request->instructor_id;
        $class->save();
        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    public function show($id)
    {
        $class = ClassModel::findOrFail($id);
        $students = Student::all();
        return view('admin.classes.show', compact('class', 'students'));
    }
    public function addStudent(Request $request, $id)
    {
        $class = ClassModel::findOrFail($id);
        $student = Student::findOrFail($request->student_id);
        $class->students()->attach($student);

        return redirect()->route('admin.classes.show', $class->id)->with('success', 'Student added to class successfully');
    }
    public function edit($class)
    {
        //    dd($class);
        $class_data = ClassModel::where('id', $class)->firstOrFail();

        return view('admin.classes.edit', compact('class_data'));
    }

    public function update(Request $request, $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $class->update($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
}
