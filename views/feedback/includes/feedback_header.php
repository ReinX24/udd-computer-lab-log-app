<main>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
        <div class="container-fluid">
            <a class="navbar-brand fs-4" href="/">Universidad de Dagupan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 fs-5">
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage == "index" ? "active" : ""; ?>" href="/">Home</a>
                    </li>
                    <li>
                        <a class="nav-link <?= $currentPage == "feedbackForm" ? "active" : ""; ?>" href="/feedback/create">Submit Feedback</a>
                    </li>
                    <li>
                        <a class="nav-link <?= $currentPage == "adminLoginForm" ? "active" : ""; ?>" href="/feedback/admin_login">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>