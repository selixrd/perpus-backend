@extends('layouts.app')

@section('title','Browse Books')

@section('content')

<div class="container">

<h3 class="mb-4 fw-bold">Browse Books</h3>

<form method="GET" class="mb-3">
<input type="text"
name="search"
class="form-control"
placeholder="Search book..."
value="{{ request('search') }}">
</form>

<div class="card shadow-lg border-0">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0 bordered-table">

<thead class="table-light">

<tr>
<th style="width:30%">Title</th>
<th>Author</th>
<th class="text-center">Status</th>
<th class="text-center">Stock</th>
<th class="text-center" style="width:120px">Action</th>
</tr>

</thead>

<tbody>

@forelse($books as $book)

<tr class="browse-row">

<td class="fw-semibold">
{{ $book->title }}
</td>

<td class="text-muted">
{{ $book->author }}
</td>

<td class="text-center">

@if($book->status == 'available')

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

@if($book->stock > 0)

<span class="badge bg-primary">
{{ $book->stock }}
</span>

@else

<span class="badge bg-danger">
Stok habis
</span>

@endif

</td>

<td class="text-center">

<a href="{{ route('user.book.detail',$book->id) }}"
class="btn btn-info btn-sm">
Detail
</a>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center text-muted py-4">
No books found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

<div class="mt-3">
{{ $books->links() }}
</div>

</div>

@endsection


<style>

.bordered-table th,
.bordered-table td{
border:1px solid #e9ecef;
}

.browse-row:hover{
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