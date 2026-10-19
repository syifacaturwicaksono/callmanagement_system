@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Tambah User</h3>

    <form method="POST" action="/users/store">
        @csrf

        <div class="mb-2">
            <label>Username</label>
            <input type="text" name="username" class="form-control">
        </div>
        
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-2">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="cm">CM</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>

    </form>

</div>

@endsection