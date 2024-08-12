@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $course->title }}</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Course Details</div>

                    <div class="card-body">
                        <p>{{ $course->description }}</p>
                        <p><strong>Instructor:</strong> {{ $course->instructor->name }}</p>
                        <p><strong>Duration:</strong> {{ $course->duration }} hours</p>
                        @if($enrolled)
                            <p class="text-success">You are enrolled in this course.</p>
                        @else
                            <form action="{{ route('student.courses.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Enroll Now</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
