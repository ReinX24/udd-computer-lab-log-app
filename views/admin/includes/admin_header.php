<main>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
        <div class="container-fluid">
            <a class="navbar-brand fs-4" href="/admin/dashboard">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 fs-5">
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage == "adminIndex" ? "active" : ""; ?>" href="/admin/dashboard">Home</a>
                    </li>
                    <li>
                        <a class="nav-link <?= $currentPage == "adminSearch" ? "active" : ""; ?>" href="/admin/search">Search</a>
                    </li>
                    <li>
                        <a class="nav-link <?= $currentPage == "adminAccounts" ? "active" : ""; ?>" href="/admin/accounts">Admin Accounts</a>
                    </li>
                    <li>
                        <a class="nav-link <?= $currentPage == "adminAccount" ? "active" : ""; ?>" href="/admin/account">Account</a>
                    </li>
                </ul>
                <a href="/admin/logout" class="btn btn-danger btn-lg">Logout</a>
            </div>
        </div>
    </nav>