@extends('layouts.app')
@include('admin.components.slidebar')
@include('admin.components.top_nav')

@section('content')
    <div class="right_col" role="main" style="min-height: 3829.67px;">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Class Details: {{ $class->name }}</h3>
                </div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Class Information</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a class="dropdown-item" href="#">Settings 1</a></li>
                                        <li><a class="dropdown-item" href="#">Settings 2</a></li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel">
                                        <div class="x_content">
                                            <h4>Class Name: {{ $class->name }}</h4>
                                            <p>Description: {{ $class->description }}</p>

                                            <h2 class="mt-4">Add Student</h2>
                                            <form action="{{ route('admin.classes.addStudent', $class->id) }}" method="POST">
                                                @csrf
                                                <div class="item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="student_id">Select Student
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 ">
                                                        <select name="student_id" id="student_id" class="form-select form-control" required>
                                                            <option value="">Select Student</option>
                                                            @foreach($students as $student)
                                                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Student</button>
                                            </form>

                                            <h2 class="mt-4">Enrolled Students</h2>
                                            <ul class="list-group">
                                                @foreach($class->students as $student)
                                                    <li class="list-group-item">{{ $student->first_name }} {{ $student->last_name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
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
