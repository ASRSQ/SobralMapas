<!-- Topbar -->
<nav class="navbar navbar-expand-lg bg-primary position-relative">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo à Esquerda -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('img/Logo_Sobral.png') }}" alt="Prefeitura de Sobral" class="logo me-2" height="40">
        </a>

        <!-- Título e Botão Hamburguer -->
        <div class="d-flex align-items-center justify-content-between flex-grow-1">
            <h1 class="text-white mb-0 fw-bold d-block d-md-none position-absolute start-50 translate-middle-x" style="font-size: 1.2rem; text-align: center;">
                Sobral em <span style="color: #ffc107;">Mapas</span>
            </h1>
            <h1 class="text-white mb-0 fw-bold d-none d-md-block position-absolute start-50 translate-middle-x" style="font-size: 2rem;">
                Sobral em <span style="color: #ffc107;">Mapas</span>
            </h1>
        </div>  

        <!-- Botão Hamburguer -->
        <button class="navbar-toggler d-lg-none" type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#fullscreenMenu" 
        aria-controls="fullscreenMenu" 
        aria-label="Toggle navigation">
        <span class="fa-solid fa-bars" id="menuIcon"></span>
        </button>

        <!-- Menu Abaixo (Telas Grandes) -->
        <div class="menu-below d-none d-lg-block">
            <ul class="navbar-nav justify-content-center py-2" style="font-weight: bold;">
                <li class="nav-item px-3">
                    <a class="nav-link" href="#tutorial">
                        <i class="fa-solid fa-book me-1"></i> Tutorial
                    </a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#contato">
                        <i class="fa-solid fa-envelope me-1"></i> Contato
                    </a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#sobre">
                        <i class="fa-solid fa-circle-info me-1"></i> Sobre
                    </a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#login">
                        <i class="fa-solid fa-user me-1"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>  
</nav>

<!-- Menu Offcanvas -->
<div class="offcanvas offcanvas-top fullscreen-menu d-lg-none" tabindex="-1" id="fullscreenMenu" aria-labelledby="fullscreenMenuLabel">
    <div class="offcanvas-header justify-content-end">
        <!-- Botão Hamburguer -->
        <button class="navbar-toggler d-lg-none justify-content-end" type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#fullscreenMenu" 
        aria-controls="fullscreenMenu" 
        aria-label="Toggle navigation">
        <span class="fa-solid fa-bars" id="menuIcon"></span>
        </button>    
    </div>
    <div class="offcanvas-body d-flex flex-column align-items-center justify-content-center">
        <ul class="menu-items list-unstyled text-center mb-0">
            <li class="mb-3">
                <a href="#tutorial" class="fs-4 text-decoration-none">
                    <i class="fa-solid fa-book me-2"></i> Tutorial
                </a>
            </li>
            <li class="mb-3">
                <a href="#contato" class="fs-4 text-decoration-none">
                    <i class="fa-solid fa-envelope me-2"></i> Contato
                </a>
            </li>
            <li class="mb-3">
                <a href="#sobre" class="fs-4 text-decoration-none">
                    <i class="fa-solid fa-circle-info me-2"></i> Sobre
                </a>
            </li>
            <li class="mb-3">
                <a href="#login" class="fs-4 text-decoration-none">
                    <i class="fa-solid fa-user me-2"></i> Login
                </a>
            </li>
        </ul>
    </div>
</div>

