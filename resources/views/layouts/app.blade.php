<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title','App')</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f1f5f9;
font-family:'Poppins', sans-serif;
}

/* SIDEBAR */

.sidebar{
width:240px;
height:100vh;
background:white;
border-right:1px solid #e5e7eb;
position:fixed;
top:0;
left:0;
transition:0.3s;
z-index:1000;
box-shadow:0 0 20px rgba(0,0,0,0.05);
}

.sidebar.hide{
transform:translateX(-240px);
}

.sidebar h4{
font-weight:600;
padding:30px 20px 10px 20px;
color:#4f46e5;
}

/* MENU */

.sidebar a{
color:#374151;
display:block;
padding:12px 20px;
text-decoration:none;
border-radius:8px;
margin:4px 10px;
font-size:14px;
}

.sidebar a:hover{
background:#EEF2FF;
color:#4f46e5;
}

.sidebar a.active{
background:#EEF2FF;
color:#4f46e5;
font-weight:500;
}

/* CONTENT */

.content{
margin-left:240px;
padding:25px;
transition:0.3s;
min-height:100vh;
}

.sidebar.hide + .content{
margin-left:0;
}

/* TOPBAR */

.topbar{
height:65px;
background:#6366F1;
color:white;
display:flex;
align-items:center;
justify-content:space-between;
padding:0 20px;
border-radius:10px;
margin-bottom:20px;
}

.toggle{
font-size:22px;
cursor:pointer;
color:white;
}

/* USER */

.user-menu{
background:transparent;
border:none;
font-weight:500;
color:white;
}

.user-menu:focus{
outline:none;
box-shadow:none;
}

/* CARD */

.card{
border:none;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
transition:0.2s;
}

.card:hover{
box-shadow:0 12px 25px rgba(0,0,0,0.08);
}

/* TABLE */

.table-responsive{
overflow-x:auto;
}

.table{
white-space:nowrap;
}

/* LOADING */

#loading{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(255,255,255,0.7);
display:none;
align-items:center;
justify-content:center;
z-index:9999;
}

.spinner-border{
width:3rem;
height:3rem;
color:#6366F1;
}

/* MOBILE */

@media (max-width:768px){

.sidebar{
transform:translateX(-240px);
}

.sidebar.show{
transform:translateX(0);
}

.content{
margin-left:0;
padding:15px;
}

.topbar{
border-radius:8px;
}

.container{
padding-left:10px;
padding-right:10px;
}

.card{
margin-bottom:15px;
}

}

</style>

</head>

<body>

<!-- LOADING -->
<div id="loading">
<div class="spinner-border"></div>
</div>

<!-- SIDEBAR -->

<div class="sidebar" id="sidebar">

<h4>Perpustakaan</h4>
<hr>

@if(auth()->user()->role == 'admin')

<a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
Dashboard
</a>

<a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
Books
</a>

<a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
Students
</a>

@else

<a href="{{ route('user.books') }}" class="{{ request()->routeIs('user.books') ? 'active' : '' }}">
Browse Books
</a>

<a href="{{ route('user.mybooks') }}" class="{{ request()->routeIs('user.mybooks') ? 'active' : '' }}">
My Borrowed Books
</a>

@endif

</div>


<!-- CONTENT -->

<div class="content">

<div class="topbar">

<div class="toggle" id="toggle-btn">
☰
</div>

<div class="dropdown">

<button class="dropdown-toggle user-menu"
type="button"
data-bs-toggle="dropdown">

Hi, {{ auth()->user()->name }}

</button>

<ul class="dropdown-menu dropdown-menu-end">

@if(auth()->user()->role != 'admin')

<li>
<a class="dropdown-item" href="{{ route('user.profile') }}">
Profile
</a>
</li>

@endif

<li>
<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="dropdown-item">
Logout
</button>
</form>
</li>

</ul>

</div>

</div>

<div class="mt-4">
@yield('content')
</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

/* SIDEBAR TOGGLE */

const toggle = document.getElementById("toggle-btn");
const sidebar = document.getElementById("sidebar");

toggle.addEventListener("click", function(){

if(window.innerWidth < 768){

sidebar.classList.toggle("show");

}else{

sidebar.classList.toggle("hide");

}

});


/* AUTO CLOSE SIDEBAR MOBILE */

document.querySelectorAll(".sidebar a").forEach(link => {

link.addEventListener("click", function(){

if(window.innerWidth < 768){
sidebar.classList.remove("show");
}

});

});


/* LOADING SPINNER */

document.querySelectorAll("form").forEach(form => {

form.addEventListener("submit", function(){
document.getElementById("loading").style.display = "flex";
});

});


/* CONFIRM DELETE */

document.querySelectorAll(".btn-delete").forEach(button => {

button.addEventListener("click", function(e){

e.preventDefault();

let form = this.closest("form");

Swal.fire({
title:"Delete data?",
text:"Data tidak bisa dikembalikan!",
icon:"warning",
showCancelButton:true,
confirmButtonColor:"#d33",
cancelButtonColor:"#6c757d",
confirmButtonText:"Delete",
cancelButtonText:"Cancel"
}).then((result)=>{

if(result.isConfirmed){
form.submit();
}

});

});

});

</script>

@php
$message = null;

if(session('success')){
$message = session('success');
}

if(session('status') == 'profile-updated'){
$message = "Akun berhasil diperbarui";
}

if(session('status') == 'password-updated'){
$message = "Password berhasil diperbarui";
}
@endphp

@if($message)
<script>

Swal.fire({
toast:true,
position:'top-end',
icon:'success',
title:"{{ $message }}",
showConfirmButton:false,
timer:2000,
timerProgressBar:true
});

</script>
@endif


</body>
</html>