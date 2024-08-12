@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Students</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Courses Enrolled</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->courses->count() }}</td>
                    <td><a href="{{ route('instructor.students.show', $student->id) }}" class="btn btn-info">View</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
