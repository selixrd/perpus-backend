<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-body">
            <h4>Edit Book</h4>

            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Cover</label>
                    <input type="file" name="cover" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $book->title }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Author</label>
                    <input type="text" name="author" value="{{ $book->author }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Year</label>
                    <input type="number" name="year" value="{{ $book->year }}" class="form-control">
                </div>

                <div class="mb-3">
                     <label>Stock</label>
                     <input type="number" name="stock" value="{{ $book->stock }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="available" {{ $book->status == 'available' ? 'selected' : '' }}>available</option>
                        <option value="borrowed" {{ $book->status == 'borrowed' ? 'selected' : '' }}>borrowed</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ $book->description }}</textarea>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>