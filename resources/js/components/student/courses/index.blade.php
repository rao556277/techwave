@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Available Courses</h1>
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            {{ $course->title }}
                        </div>
                        <div class="card-body">
                            <p>{{ Str::limit($course->description, 100) }}</p>
                            <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
