<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="pwd" placeholder="Password" required>
    <select name="role" required>
        <option value="Admin">Admin</option>
        <option value="Instructor">Instructor</option>
        <option value="Student">Student</option>
    </select>
    <input type="file" name="image">
    <button type="submit">Create User</button>
</form>
