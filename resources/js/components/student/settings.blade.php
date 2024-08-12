@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Settings</h1>
        <form action="{{ route('student.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
@endsection
