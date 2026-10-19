@extends('layouts.admin')

@section('content')

<h3>Data Teknisi</h3>

<a href="/technicians/create" class="btn btn-primary mb-3">
    ➕ Tambah Teknisi
</a>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($technicians as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->name }}</td>
            <td>{{ $t->phone }}</td>
            <td>
                <a href="/technicians/edit/{{ $t->id }}" class="btn btn-warning btn-sm">
                Edit
                </a>

                <a href="/technicians/delete/{{ $t->id }}"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Hapus teknisi?')">
                 Hapus
    </a>
</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection