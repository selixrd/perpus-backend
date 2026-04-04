@extends('layouts.app')

@section('title','My Borrowed Books')

@section('content')

<div class="container">

<h3 class="mb-4 fw-bold">My Borrowed Books</h3>

<div class="card shadow-lg border-0">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0 bordered-table">

<thead class="table-light">

<tr>
<th style="width:40%">Book</th>
<th class="text-center">Borrow Date</th>
<th class="text-center">Return Date</th>
<th class="text-center">Status</th>
</tr>

</thead>

<tbody>

@forelse($borrowings as $borrow)

<tr class="borrow-row">

<td>
<div class="fw-semibold">
{{ $borrow->book->title }}
</div>
</td>

<td class="text-muted text-center">
{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}
</td>

<td class="text-muted text-center">
{{ $borrow->return_date ?? '-' }}
</td>

<td class="text-center">

@if($borrow->return_date)

<span class="badge bg-success px-3 py-2">
Returned
</span>

@else

<span class="badge bg-warning text-dark px-3 py-2">
Borrowed
</span>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center text-muted py-4">
No borrowed books yet
</td>
</tr>

@endforelse

</tbody>

</table>

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

.borrow-row:hover{
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