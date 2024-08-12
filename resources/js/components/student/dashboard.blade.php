<!-- resources/views/student/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $user->name }}!</h1>

    <div class="row">
        <div class="col-md-8">
            <h2>Your Enrolled Courses</h2>
{{--            @if($enrolledCourses->isEmpty())--}}
{{--                <p>You are not enrolled in any courses yet.</p>--}}
{{--            @else--}}
{{--                <ul>--}}
{{--                    @foreach($enrolledCourses as $course)--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('student.courses.show', $course) }}">--}}
{{--                                {{ $course->title }}--}}
{{--                            </a>--}}
{{--                            - {{ $course->pivot->enrolled_at->format('d M Y') }} <!-- Example pivot field -->--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            @endif--}}
        </div>
    </div>
</div>
@endsection
