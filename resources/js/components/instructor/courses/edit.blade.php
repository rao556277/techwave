@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Course</h1>
        <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $course->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ $course->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>
@endsection
