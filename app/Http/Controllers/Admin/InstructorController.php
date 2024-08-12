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
    /**
     * Display a list of instructors.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $instructors = Instructor::paginate(10);
        return response()->json($instructors);
    }

    /**
     * Store a newly created instructor in storage.
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

        return response()->json(['success' => 'Instructor created successfully.', 'instructor' => $instructor], 201);
    }

    /**
     * Display the specified instructor.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);
        return response()->json($instructor);
    }

    /**
     * Update the specified instructor.
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

        return response()->json(['success' => 'Instructor updated successfully.', 'instructor' => $instructor]);
    }

    /**
     * Remove the specified instructor from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        if ($instructor->image) {
            Storage::delete('public/' . $instructor->image);
        }
        $instructor->delete();

        return response()->json(['success' => 'Instructor deleted successfully.']);
    }
}
