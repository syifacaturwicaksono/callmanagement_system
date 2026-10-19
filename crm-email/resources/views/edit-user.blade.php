@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Edit User</h3>

    <form method="POST" action="/users/update/{{ $user->id }}">
        @csrf

        <div class="mb-2">
            <label>Username</label>
            <input type="text" name="username" value="{{ $user->username }}" class="form-control">
        </div>

        <div class="mb-2">
            <label>Password (opsional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-2">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="cm" {{ $user->role == 'cm' ? 'selected' : '' }}>CM</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>

    </form>

</div>

@endsection