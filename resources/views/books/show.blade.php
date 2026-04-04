<!DOCTYPE html>
<html>
<head>
    <title>Detail Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: lightgray">

<div class="container mt-5">

    <div class="card shadow rounded mb-4">
        <div class="card-body">

            <h3>{{ $book->title }}</h3>
            <hr>

            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" width="200" class="mb-3">
            @endif

            <p><b>Author:</b> {{ $book->author }}</p>
            <p><b>Year:</b> {{ $book->year }}</p>
            <p><b>Status:</b> {{ $book->status }}</p>

            <p><b>Description:</b></p>
            <p>{{ $book->description }}</p>

            <a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Edit</a>

        </div>
    </div>

    {{-- Borrow History --}}
    <div class="card shadow rounded">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Borrow History</h5>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($book->borrowings as $borrow)

                    <tr>
                        <td>{{ $borrow->student->name }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td>{{ $borrow->return_date ?? '-' }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="text-center">
                            No borrowing history
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>