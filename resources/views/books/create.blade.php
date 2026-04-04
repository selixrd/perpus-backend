<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Book</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: lightgray">

<div class="container mt-5 mb-5">

<div class="card border-0 shadow-sm rounded">

<div class="card-body">

<h4 class="mb-3">Add Book</h4>

<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
<label class="form-label fw-bold">COVER</label>
<input type="file" name="cover" class="form-control">
</div>

<div class="mb-3">
<label class="form-label fw-bold">TITLE</label>
<input type="text" name="title" value="{{ old('title') }}" class="form-control">
</div>

<div class="mb-3">
<label class="form-label fw-bold">AUTHOR</label>
<input type="text" name="author" value="{{ old('author') }}" class="form-control">
</div>

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label fw-bold">YEAR</label>
<input type="number" name="year" value="{{ old('year') }}" class="form-control">
</div>

<div class="col-md-4 mb-3">
<label class="form-label fw-bold">STOCK</label>
<input type="number" name="stock" value="{{ old('stock',1) }}" class="form-control">
</div>

</div>

<div class="mb-3">
<label class="form-label fw-bold">DESCRIPTION</label>
<textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
</div>

<button class="btn btn-primary">SAVE</button>
<a href="{{ route('books.index') }}" class="btn btn-secondary">BACK</a>

</form>

</div>
</div>
</div>

</body>
</html>