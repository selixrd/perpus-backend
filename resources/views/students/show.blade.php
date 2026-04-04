@extends('layouts.app')

@section('title','Detail Siswa')

@section('content')

<div class="container mt-4">

<div class="card border-0 shadow-sm mb-4">

<div class="card-body">

<h4 class="fw-bold mb-3">Detail Siswa</h4>

<table class="table table-bordered">

<tr>
<th width="25%">Nama</th>
<td>{{ $student->name }}</td>
</tr>

<tr>
<th>NIS</th>
<td>{{ $student->nis }}</td>
</tr>

<tr>
<th>Kelas</th>
<td>{{ $student->class }}</td>
</tr>

<tr>
<th>Jurusan</th>
<td>{{ $student->major ?? '-' }}</td>
</tr>

<tr>
<th>Alamat</th>
<td>{{ $student->address ?? '-' }}</td>
</tr>

</table>

<a href="{{ route('students.index') }}" class="btn btn-secondary">
Kembali
</a>

<a href="{{ route('students.edit',$student->id) }}" class="btn btn-primary">
Edit
</a>

</div>
</div>


<div class="card border-0 shadow-sm">

<div class="card-body">

<h5 class="fw-bold mb-3">Buku yang Dipinjam</h5>

<table class="table table-bordered">

<thead>

<tr>
<th>Judul Buku</th>
<th>Tanggal Pinjam</th>
<th>Tanggal Kembali</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

@forelse($student->borrowings as $borrow)

<tr>

<td>{{ $borrow->book->title }}</td>

<td>{{ $borrow->borrow_date }}</td>

<td>{{ $borrow->return_date ?? '-' }}</td>

<td>

@if(!$borrow->return_date)

<form action="{{ route('return.book',$borrow->book_id) }}"
method="POST">

@csrf

<button class="btn btn-warning btn-sm">
Return
</button>

</form>

@else

<span class="badge bg-success">
Returned
</span>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center">
Belum ada buku dipinjam
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection