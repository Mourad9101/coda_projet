<nav class="navbar navbar-expand-lg bg-dark text-white fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white" >Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php?component=products">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php?component=categories">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php?component=users">Users</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <ul class="dropdown-menu bg-dark text-white">
                        <li><a class="dropdown-item text-white" href="?deconnect">Se déconnecter</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>