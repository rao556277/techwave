<!-- resources/views/instructor/students/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $student->first_name }} {{ $student->last_name }} - Details</h1>
        <div class="card">
            <div class="card-header">
                <h3>Student Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $student->email }}</p>
                <p><strong>Contact:</strong> {{ $student->contact }}</p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3>Courses Enrolled</h3>
            </div>
            <div class="card-body">
                <ul>
                    @foreach($courses as $course)
                        <li>{{ $course->title }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
