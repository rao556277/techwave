<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a list of students.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    /**
     * Store a newly created student in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'cnic' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Student',
        ]);

        $student = new Student($request->except('password', 'image'));
        $student->password = Hash::make($request->password);
        $student->user_id = $user->id;

        if ($request->hasFile('image')) {
            $student->image = $request->file('image')->store('images', 'public');
        }

        $student->save();

        return response()->json(['success' => 'Student created successfully.', 'student' => $student], 201);
    }

    /**
     * Display the specified student.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    /**
     * Update the specified student.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'cnic' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email,' . $id,
            'password' => 'nullable|string|min:8',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $student = Student::findOrFail($id);
        $student->fill($request->except('password', 'image'));

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            if ($student->image) {
                Storage::delete('public/' . $student->image);
            }
            $student->image = $request->file('image')->store('images', 'public');
        }

        $student->save();

        return response()->json(['success' => 'Student updated successfully.', 'student' => $student]);
    }

    /**
     * Remove the specified student from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->image) {
            Storage::delete('public/' . $student->image);
        }

        $student->delete();

        return response()->json(['success' => 'Student deleted successfully.']);
    }
}
