<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Dashboard - Pelanggan</title>
   <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
   <style>
       body {
           margin: 0;
           padding: 0;
           font-family: sans-serif;
           background-color: #f0f0f0;
       }

       .custom-container {
           width: 100%;
           max-width: 700px;
           margin: 0 auto;
           padding: 20px;
           background-color: #fff;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       }

       .header {
           display: flex;
           justify-content: space-between;
           align-items: center;
           padding: 10px 0;
           background-color: #4CAF50;
           color: #fff;
       }

       .header .user {
           display: flex;
           align-items: center;
       }

       .header .user img {
           width: 30px;
           height: 30px;
           border-radius: 50%;
       }

       .header .user p {
           margin-left: 10px;
       }

       .header .logo img {
           width: 50px;
           height: 50px;
       }

       .search {
           display: flex;
           justify-content: space-between;
           align-items: center;
           padding: 10px 0;
           margin-bottom: 20px;
       }

       .search input {
           width: 100%;
           padding: 10px;
           border: 1px solid #ddd;
           border-radius: 5px;
       }

       .search button {
           background-color: #52c2cc;
           color: #fff;
           border: none;
           padding: 10px 20px;
           border-radius: 5px;
           cursor: pointer;
       }

       .budget-list {
           list-style: none;
           padding: 0;
           margin: 0;
       }

       .budget-list li {
           padding: 10px;
           border-bottom: 1px solid #ddd;
       }

       .budget-item .budget-category {
           font-weight: bold;
       }

       .budget-item .budget-amount {
           font-size: 18px;
           font-weight: bold;
       }

       .budget-item .budget-actions button {
           background-color: #52c2cc;
           color: #fff;
           border: none;
           padding: 5px 10px;
           border-radius: 5px;
           cursor: pointer;
       }
   </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-white shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
               <strong>Selamat Datang di Kantin FT UNY</strong>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown">Hello, Mohit</a>
                            <ul class="dropdown-menu border-0 shadow">
                                <li><a class="dropdown-item" href="#!">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container custom-container my-5">
        <header class="header">
            <div class="user">
                <img src="https://via.placeholder.com/30" alt="User Image">
                <p>Selamat Datang Owner!</p>
            </div>
            <div class="logo">
                <img src="https://via.placeholder.com/50" alt="Logo">
            </div>
        </header>
        
        <div class="search">
            <input type="text" placeholder="Search...">
            <button>Search</button>
        </div>
        
        <ul class="budget-list">
            <li>
                <div class="budget-item d-flex justify-content-between">
                    <p class="budget-category">Income</p>
                    <p class="budget-amount">Rp 10.000.000</p>
                    <div class="budget-actions d-flex gap-2">
                        <button>Edit</button>
                        <button>Delete</button>
                    </div>
                </div>
            </li>
            <li>
                <div class="budget-item d-flex justify-content-between">
                    <p class="budget-category">Expenses</p>
                    <p class="budget-amount">Rp 5.000.000</p>
                    <div class="budget-actions d-flex gap-2">
                        <button>Edit</button>
                        <button>Delete</button>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
