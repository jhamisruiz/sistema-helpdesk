<header class='mb-3'>
    <nav class="navbar navbar-expand navbar-light">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-end mr-5" id="navbarSupportedContent">
                <div class="dropdown mr-5">
                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="public/assets/images/faces/1.jpg">
                                </div>
                            </div>
                            <div class="user-name text-start me-3">
                                <h6 id="idnames" class="mb-0 text-gray-600">
                                </h6>
                                <p id="iduser_ses" class="mb-0 text-sm text-gray-600">
                                </p>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start border border-primary" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 id="idnames_last" class="dropdown-header">
                            </h6>

                        </li>
                        <li><a class="dropdown-item" href="pedidos-pedidos">
                                <i class="icon-mid bi bi-wallet me-2"></i>
                                Pedidos
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="clientes-clientes">
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                Clientes</a></li>
                        <li><a class="dropdown-item" href="usuarios-usuarios">
                                <i class="icon-mid bi  bi-person me-2"></i>
                                Usuarios</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="closeSession()" href="salir">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>