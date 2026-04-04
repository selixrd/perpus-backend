@extends('layouts.app')

@section('title','Profil Saya')

@section('content')

<div class="container">

<h3 class="mb-4">Profil Saya</h3>

<div class="row">

<!-- ACCOUNT -->

<div class="col-md-6">

<div class="card shadow-sm mb-4">
<div class="card-body">

<h5 class="mb-3">Informasi Akun</h5>

<form method="POST" action="{{ route('profile.update') }}">
@csrf
@method('PATCH')

<div class="mb-3">
<label class="form-label">Nama</label>
<input type="text" name="name"
class="form-control"
value="{{ auth()->user()->name }}">
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email"
class="form-control"
value="{{ auth()->user()->email }}">
</div>

<button class="btn btn-primary w-100">
Perbarui Akun
</button>

</form>

</div>
</div>


<div class="card shadow-sm">
<div class="card-body">

<h5 class="mb-3">Ubah Password</h5>

<form method="POST" action="{{ route('password.update') }}">
@csrf
@method('PUT')

<div class="mb-3">
<label class="form-label">Password Saat Ini</label>
<input type="password" name="current_password"
class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Password Baru</label>
<input type="password" name="password"
class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Konfirmasi Password</label>
<input type="password" name="password_confirmation"
class="form-control">
</div>

<button class="btn btn-warning w-100">
Perbarui Password
</button>

</form>

</div>
</div>

</div>

<!-- STUDENT PROFILE -->

<div class="col-md-6">

<div class="card shadow-sm">
<div class="card-body">

<h5 class="mb-3">Informasi Siswa</h5>

<form method="POST" action="{{ route('user.profile.store') }}">
@csrf

<div class="mb-3">
<label class="form-label">Nama Lengkap</label>
<input type="text" name="name"
class="form-control"
value="{{ old('name', optional($student)->name) }}">
</div>

<div class="mb-3">
<label class="form-label">NIS</label>
<input type="text" name="nis"
class="form-control"
value="{{ old('nis', optional($student)->nis) }}">
</div>

<div class="mb-3">
<label class="form-label">Kelas</label>
<input type="text" name="class"
class="form-control"
value="{{ old('class', optional($student)->class) }}">
</div>

<div class="mb-3">
<label class="form-label">Jurusan</label>
<input type="text" name="major"
class="form-control"
value="{{ old('major', optional($student)->major) }}">
</div>

<div class="mb-3">
<label class="form-label">Alamat</label>
<textarea name="address"
class="form-control"
rows="3">{{ old('address', optional($student)->address) }}</textarea>
</div>

<button class="btn btn-success w-100">
Simpan Profil Siswa
</button>

</form>

</div>
</div>

</div>

</div>

</div>

@endsection