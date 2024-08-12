@extends('layouts.app')
@include('instructor.components.top_nav')
@include('instructor.components.slidebar')

@section('content')
    @yield('script')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>My Courses <small>Manage your courses effectively</small></h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button">Go!</button>
                        </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>All Courses <small>Instructor</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <div class="d-flex justify-content-end mb-4">
                                            <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">Create New Course</a>
                                        </div>
                                        <p class="text-muted font-13 m-b-30">
                                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                                        </p>
                                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody id="courses-table-body">
                                            @foreach($courses as $course)
                                                <tr>
                                                    <td>{{ $course->title }}</td>
                                                    <td>{{ Str::limit($course->description, 100) }}</td>
                                                    <td>
                                                        <a href="{{ route('instructor.courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a>
                                                        <a href="{{ route('instructor.courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let search = $(this).val();
                $.ajax({
                    url: "{{ route('instructor.courses.index') }}",
                    type: "GET",
                    data: { search: search },
                    success: function(response) {
                        let courses = response.courses;
                        let coursesTableBody = $('#courses-table-body');
                        coursesTableBody.empty();

                        courses.forEach(course => {
                            let courseRow = `<tr>
                            <td>${course.title}</td>
                            <td>${course.description}</td>
                            <td>
                                <a href="{{ route('instructor.courses.show', '') }}/${course.id}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('instructor.courses.edit', '') }}/${course.id}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('instructor.courses.destroy', '') }}/${course.id}" method="POST" style="display:inline;">
                                    @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>`;
                            coursesTableBody.append(courseRow);
                        });
                    }
                });
            });
        });
    </script>
@endsection
