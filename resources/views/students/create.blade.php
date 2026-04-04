<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

<div class="container mt-5">
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <h4 class="fw-bold mb-3">Tambah Siswa</h4>

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kelas</label>
                    <input type="text" name="class" value="{{ old('class') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jurusan</label>
                    <input type="text" name="major" value="{{ old('major') }}" class="form-control"
                    placeholder="Isi Jurusan">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea name="address" rows="3" class="form-control">{{ old('address') }}</textarea>
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>