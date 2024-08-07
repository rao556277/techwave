<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::paginate(10);
        return view('admin.instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('admin.instructors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:instructors|unique:users',
            'password' => 'required|string|min:6',
            'cnic' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => "Instructor",
        ]);
        $instructor = new Instructor($request->except('password', 'image'));
        $instructor->password = Hash::make($request->password);
        $instructor->user_id = $user->id;

        if ($request->hasFile('image')) {
            $instructor->image = $request->file('image')->store('images', 'public');
        }

        $instructor->save();

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor created successfully.');
    }

    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('admin.instructors.show', compact('instructor'));
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('admin.instructors.edit', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:instructors,email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'cnic' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $instructor = Instructor::findOrFail($id);
        $instructor->fill($request->except('password', 'image'));

        if ($request->filled('password')) {
            $instructor->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            if ($instructor->image) {
                Storage::delete('public/' . $instructor->image);
            }
            $instructor->image = $request->file('image')->store('images', 'public');
        }

        $instructor->save();

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully.');
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        if ($instructor->image) {
            Storage::delete('public/' . $instructor->image);
        }
        $instructor->delete();

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor deleted successfully.');
    }

    protected function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => "Instructor",
        ]);
    }
}
