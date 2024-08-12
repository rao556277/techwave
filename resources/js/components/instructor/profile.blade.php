@extends('layouts.app')
@include('instructor.components.top_nav')
@include('instructor.components.slidebar')
@section('content')
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-10">
                <div class="card ml-5">
                    <div class="card-header">
                        <h3 class="text-center">Instructor Profile</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('instructor.profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="text-center mb-4 position-relative">
                                <img src="{{ $instructor->image ? asset('storage/' . $instructor->image) : asset('images/default-avatar.png') }}"
                                     alt="Profile Image" class="rounded-circle" width="150" height="150">

                                <!-- Edit icon -->
                                <label for="image" class="position-absolute edit-icon">
                                    <i class="fa fa-pencil-alt"></i>
                                </label>
                                <input type="file" name="image" id="image" class="d-none">
                            </div>

                            <div class="form-group px-5">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $instructor->first_name }}" required>
                            </div>

                            <div class="form-group px-5">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $instructor->last_name }}" required>
                            </div>

                            <div class="form-group px-5">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $instructor->email }}" required>
                            </div>

                            <div class="form-group px-5">
                                <label for="contact">Contact</label>
                                <input type="text" name="contact" id="contact" class="form-control" value="{{ $instructor->contact }}">
                            </div>

                            <div class="form-group px-5">
                                <label for="bio">Bio</label>
                                <textarea name="bio" id="bio" class="form-control" rows="4">{{ $instructor->bio }}</textarea>
                            </div>



                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .edit-icon {
            bottom: 10px;
            right: 433px;
            background-color: #ff4081;
            color: white;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }
        .edit-icon i {
            font-size: 16px;
        }
    </style>
@endsection
