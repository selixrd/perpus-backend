@extends('layouts.app')
@section('title', 'Data Students')

@section('content')

<div class="container">

<div class="card border-0 shadow-lg rounded-3">

<div class="card-body">

<div class="text-center mb-4">
<h3 class="fw-bold mb-1">Data Siswa</h3>
<small class="text-muted">Kelola seluruh data siswa</small>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">

<h5 class="mb-0 fw-semibold">Daftar Siswa</h5>

<a href="{{ route('students.create') }}" class="btn btn-success btn-sm">
Tambah Siswa
</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle mb-0 bordered-table">

<thead class="table-light">

<tr>
<th>Nama</th>
<th>NIS</th>
<th>Kelas</th>
<th>Jurusan</th>
<th>Alamat</th>
<th class="text-center" style="width:220px">Aksi</th>
</tr>

</thead>

<tbody>

@forelse($students as $student)

<tr class="student-row">

<td class="fw-semibold">
{{ $student->name }}
</td>

<td class="text-muted">
{{ $student->nis }}
</td>

<td class="text-muted">
{{ $student->class }}
</td>

<td class="text-muted">
{{ $student->major ?? '-' }}
</td>

<td class="text-muted">
{{ $student->address ?? '-' }}
</td>

<td class="text-center">

<a href="{{ route('students.show', $student->id) }}"
class="btn btn-dark btn-sm">
Show
</a>

<a href="{{ route('students.edit', $student->id) }}"
class="btn btn-primary btn-sm">
Edit
</a>

<form action="{{ route('students.destroy', $student->id) }}"
method="POST"
class="d-inline"
onsubmit="return confirm('Yakin hapus?')">

@csrf
@method('DELETE')

<button type="submit"
class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center py-4 text-muted">
Belum ada data siswa.
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-3">
{{ $students->links() }}
</div>

</div>
</div>

</div>

@endsection


<style>

.bordered-table th,
.bordered-table td{
border:1px solid #e9ecef;
}

.student-row:hover{
background:#fafafa;
transition:0.2s;
}

.card{
border-radius:12px;
}

.bordered-table td{
padding:14px 16px;
}

</style>