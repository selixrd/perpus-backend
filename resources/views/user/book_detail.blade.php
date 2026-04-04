@extends('layouts.app')

@section('title','Book Detail')

@section('content')

<div class="container">

<h3>{{ $book->title }}</h3>

@if($book->cover)
<img src="{{ asset('storage/'.$book->cover) }}" width="200">
@endif

<p><b>Author:</b> {{ $book->author }}</p>
<p><b>Year:</b> {{ $book->year }}</p>
<p><b>Description:</b></p>
<p>{{ $book->description }}</p>

<div class="d-flex gap-2 mt-3">

<a href="{{ route('user.books') }}" class="btn btn-outline-secondary">
Back
</a>

@if($book->status == 'available')

<form action="{{ route('borrow.book',$book->id) }}" method="POST">
@csrf

<button class="btn btn-success">
Borrow
</button>

</form>

@else

<button class="btn btn-secondary" disabled>
Not Available
</button>

@endif

</div>

</div>

@endsection