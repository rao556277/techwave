<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());

        if ($user->role === 'Student') {
            $this->createStudent($request->all(),$user);
        } elseif ($user->role === 'Instructor') {
            $this->createInstructor($request->all(),$user);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Admin,Instructor,Student',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }

    protected function createInstructor(array $data ,$user)
    {
        return Instructor::create([
            'first_name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_id' => $user->id,
        ]);
    }

    protected function createStudent(array $data,$user)
    {
        return Student::create([
            'first_name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_id' => $user->id,
        ]);
    }
}
