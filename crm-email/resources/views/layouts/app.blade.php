<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HPS CRM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{ background:#f4f6f9; }

.sidebar{
    width:250px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:#1e293b;
    color:white;
}

.main-content{
    margin-left:250px;
    padding:30px;
}

.sidebar .nav-link{
    color:#cbd5f1;
    padding:1px 5px;
    border-radius:6px;
}

.sidebar .nav-link:hover{
    background:#334155;
}
.sidebar-title{
    font-weight:bold;
    font-size:20px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar p-3">

    <div class="sidebar-title mb-4">
        HPS CRM<br>
        Call Management
        <h6>Versi 08.26</h6>
    </div>

    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="/dashboard" class="nav-link">
                Message Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/wa-dashboard" class="nav-link">
                Whatsapp Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/create-email" class="nav-link">
                Create Message
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/backup-history" class="nav-link">
                Backup History
            </a>
        </li>
       
      @if(auth()->user()->role == 'admin')
<li class="nav-item mb-2">
    
    <a href="#" class="nav-link" onclick="toggleSubmenu()">Master Data ▾</a>
    
    <ul id="submenu-master" style="display: none; list-style: none; padding-left: 15px;">
        <li>
            <a href="/users" class="nav-link">Kelola Akun</a>
        </li>
        <li>
            <a href="/templates" class="nav-link">Template</a>
        </li>
        <li>
            <a href="/pics" class="nav-link">PIC</a>
        </li>
    </ul>

</li>
@endif
<script>
function toggleSubmenu() {
    var menu = document.getElementById("submenu-master");
    if (menu.style.display === "none") {
        menu.style.display = "block";
    } else {
        menu.style.display = "none";
    }
}
</script>

    </ul>

    <div style="position: absolute; bottom: 20px; width: 100%; ">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger">
            Logout
        </button>
    </form>
</div>
</div>

<!-- CONTENT -->
<div class="main-content">
    @yield('content')
</div>

</body>
</html>