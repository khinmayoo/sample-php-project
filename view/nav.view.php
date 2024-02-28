<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Note Takers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/notes/">Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/todos/">My Todos</a>
                </li>
            </ul>
        </div>
        <?php if (isLoggedIn()) : ?>
            <span class="navbar-text me-2">
                <?= $_SESSION['user']['email'] ?>
            </span>
            <span class="navbar-text me-2">
                <a href="/logout">Logout</a>
            </span>
        <?php else : ?>
            <span class="navbar-text me-2">
                <a href="/register">Register</a>
            </span>
            <span class="navbar-text me-2">
                |
            </span>
            <span class="navbar-text me-2">
                <a href="/login">Login</a>
            </span>
        <?php endif; ?>
    </div>
</nav>
<div class="container">