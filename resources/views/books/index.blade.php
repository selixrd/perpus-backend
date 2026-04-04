@extends('layouts.app')
@section('title', 'Data Books')

@section('content')

<div class="container">

<div class="card border-0 shadow-lg rounded-3">

<div class="card-body">

<div class="text-center mb-4">
<h3 class="fw-bold mb-1">Data Buku</h3>
<small class="text-muted">Kelola seluruh data buku</small>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">

<h5 class="mb-0 fw-semibold">Daftar Buku</h5>

<a href="{{ route('books.create') }}" class="btn btn-success btn-sm">
Tambah Buku
</a>

</div>

<form method="GET" action="{{ route('books.index') }}" class="mb-4">

<input type="text"
name="search"
class="form-control"
placeholder="Search book title..."
value="{{ request('search') }}">

</form>


<div class="table-responsive">

<table class="table table-hover align-middle mb-0 bordered-table">

<thead class="table-light">

<tr>
<th style="width:18%">Cover</th>
<th>Title</th>
<th>Author</th>
<th class="text-center">Year</th>
<th class="text-center">Stock</th>
<th class="text-center">Status</th>
<th class="text-center" style="width:260px">Action</th>
</tr>

</thead>

<tbody>

@forelse($books as $book)

<tr class="book-row">

<td class="text-center">

@if($book->cover)

<img src="{{ asset($book->cover) }}"
class="rounded shadow-sm"
style="width:90px">

@else

<span class="text-muted">No Cover</span>

@endif

</td>

<td class="fw-semibold">
{{ $book->title }}
</td>

<td class="text-muted">
{{ $book->author }}
</td>

<td class="text-center text-muted">
{{ $book->year ?? '-' }}
</td>

<td class="text-center">

@if($book->stock > 0)

<span class="badge bg-primary px-3 py-2">
{{ $book->stock }}
</span>

@else

<span class="badge bg-danger px-3 py-2">
0
</span>

@endif

</td>

<td class="text-center">

@if($book->stock > 0)

<span class="badge bg-success px-3 py-2">
Available
</span>

@else

<span class="badge bg-danger px-3 py-2">
Borrowed
</span>

@endif

</td>


<td class="text-center">

<a href="{{ route('books.show', $book->id) }}"
class="btn btn-dark btn-sm">
Show
</a>

<a href="{{ route('books.edit', $book->id) }}"
class="btn btn-primary btn-sm">
Edit
</a>

<form action="{{ route('books.destroy', $book->id) }}"
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

@if($book->stock > 0)

<button 
class="btn btn-success btn-sm"
data-bs-toggle="modal"
data-bs-target="#borrowModal{{ $book->id }}">
Borrow
</button>

@endif

</td>

</tr>


<div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Borrow Book</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="{{ route('borrow.book', $book->id) }}" method="POST">

@csrf

<div class="modal-body">

<p class="mb-2">
Book: <strong>{{ $book->title }}</strong>
</p>

<select name="student_id" class="form-select">

@foreach($students as $student)

<option value="{{ $student->id }}">
{{ $student->name }}
</option>

@endforeach

</select>

</div>

<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
Cancel
</button>

<button type="submit" class="btn btn-success">
Borrow
</button>

</div>

</form>

</div>
</div>
</div>


@empty

<tr>
<td colspan="7" class="text-center py-4 text-muted">
Belum ada data buku.
</td>
</tr>

@endforelse

</tbody>

</table>

</div>


<div class="mt-3">
{{ $books->links() }}
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

.book-row:hover{
background:#fafafa;
transition:0.2s;
}

.card{
border-radius:12px;
}

.badge{
font-size:0.75rem;
border-radius:20px;
}

.bordered-table td{
padding:14px 16px;
}

</style>