<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">

<a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
Perpustakaan
</a>

<button class="navbar-toggler" type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarMenu">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarMenu">

<ul class="navbar-nav me-auto">

<li class="nav-item">
<a class="nav-link" href="{{ route('dashboard') }}">
Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('books.index') }}">
Books
</a>
</li>

@if(auth()->user()->role == 'admin')
<li class="nav-item">
<a class="nav-link" href="{{ route('students.index') }}">
Students
</a>
</li>
@endif

</ul>

<div class="d-flex align-items-center gap-3">

<span class="text-white">
{{ auth()->user()->name }}
</span>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn btn-sm btn-danger">
Logout
</button>
</form>

</div>

</div>

</nav>