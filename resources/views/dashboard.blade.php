@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container">

<h2 class="mb-4 fw-bold">Library Dashboard</h2>

<div class="row g-3">

    {{-- TOTAL BOOKS --}}
    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column justify-content-center">

                <h6 class="text-muted">Total Books</h6>
                <h2 class="fw-bold">{{ $books }}</h2>

                <div class="mt-3">
                    <a href="{{ route('books.index') }}" class="btn btn-sm btn-primary">
                        View Books
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- TOTAL STUDENTS --}}
    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column justify-content-center">

                <h6 class="text-muted">Total Students</h6>
                <h2 class="fw-bold">{{ $students }}</h2>

                <div class="mt-3">
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-success">
                        View Students
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- BORROWED BOOKS --}}
    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column justify-content-center">

                <h6 class="text-muted">Borrowed Books</h6>
                <h2 class="fw-bold text-danger">{{ $borrowed }}</h2>

                <div class="mt-3 text-muted">
                    Currently borrowed
                </div>

            </div>
        </div>
    </div>

    {{-- AVAILABLE BOOKS --}}
    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column justify-content-center">

                <h6 class="text-muted">Available Books</h6>
                <h2 class="fw-bold text-success">{{ $available }}</h2>

                <div class="mt-3 text-muted">
                    Books available
                </div>

            </div>
        </div>
    </div>

</div>


{{-- RECENT ACTIVITY --}}
<div class="card mt-4">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Recent Activity</h5>

        <ul class="list-group">

        @forelse($recentActivities as $activity)

            <li class="list-group-item d-flex justify-content-between align-items-center">

                <span>

                    @if($activity->return_date)

                        🔵 <strong>{{ $activity->student->name }}</strong>
                        returned "<strong>{{ $activity->book->title }}</strong>"

                    @else

                        🟢 <strong>{{ $activity->student->name }}</strong>
                        borrowed "<strong>{{ $activity->book->title }}</strong>"

                    @endif

                </span>

                <small class="text-muted">
                    {{ $activity->created_at->diffForHumans() }}
                </small>

            </li>

        @empty

            <li class="list-group-item text-center text-muted">
                No activity yet
            </li>

        @endforelse

        </ul>

    </div>
</div>

</div>

@endsection