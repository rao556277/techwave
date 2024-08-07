<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AdminNotification;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

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
            'name' => $request->first_name.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => "Student",
        ]);
        $student = new Student($request->all());
        $student->password = Hash::make($request->password);
        if ($request->hasFile('image')) {
            $student->image = $request->file('image')->store('images', 'public');
        }
        $student->user_id = $user->id;
        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function show($id)
    {
        $student = Student::where('id', $id)->firstOrfail();
        return view('admin.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::where('id', $id)->firstOrfail();
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::where('id', $id)->firstOrfail();
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'cnic' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'password' => 'nullable|string|min:8',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $student->update($request->except('password', 'image'));

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $student->image = $request->file('image')->store('images', 'public');
        }

        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = Student::where('id', $id)->firstOrfail();

        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}

