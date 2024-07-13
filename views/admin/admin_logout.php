<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h2>Are you sure you want to logout?</h2>
    <div class="d-flex gap-2 mt-4">
        <form action="/admin/logout" method="POST">
            <input type="hidden" name="logout" value="true">
            <button type="submit" class="btn btn-danger btn-lg">Logout</button>
        </form>
        <a href="/admin/dashboard" class="btn btn-secondary btn-lg">Cancel</a>
    </div>
</div>

<?php require_once "includes/admin_footer.php"; ?>