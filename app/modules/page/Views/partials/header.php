<nav class="navbar bg-body-tertiary fixed-top">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
      aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <img src="/skins/page/images/logo.webp" alt="Logo Nogal" class="logo-header w-100">
    <span class="btn-carrito-header">
      <!-- <i class="fa-solid fa-cart-shopping ico"></i> -->
    </span>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Categorias de productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <?php foreach ($this->categoriasList as $categoria): ?>
            <li class="nav-item dropdown">

        
              <a class="nav-link <?php echo (!empty($categoria->subcategorias)) ? 'dropdown-toggle' : ''; ?>" 
                 <?php if (!empty($categoria->subcategorias)): ?>
                   data-bs-toggle="dropdown" aria-expanded="false" role="button"
                 <?php else: ?>
                   href="/page/productos?categoria=<?php echo $categoria->categoria_id; ?>"
                 <?php endif; ?>>
                <?php echo htmlspecialchars($categoria->categoria_nombre); ?>
              </a>

              <?php if (!empty($categoria->subcategorias)): ?>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="/page/productos?categoria=<?php echo $categoria->categoria_id; ?>">
                      Ver todo en <?php echo htmlspecialchars($categoria->categoria_nombre); ?>
                    </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <?php foreach ($categoria->subcategorias as $subcategoria): ?>
                    <li>
                      <a class="dropdown-item"
                        href="/page/productos?categoria=<?php echo $categoria->categoria_id; ?>&subcategoria=<?php echo $subcategoria->categoria_id; ?>">
                        <?php echo htmlspecialchars($subcategoria->categoria_nombre); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

            </li>
          <?php endforeach; ?>
          <?php if ($this->socio && $this->socio->SBE_CODI): ?>
                    <li class="nav-item">
                      <a class="nav-link text-danger" href="/page/index/logout">
                        <i class="fa-solid fa-sign-out-alt"></i> Cerrar sesión
                      </a>
                    </li>
          <?php else: ?>
                    <li class="nav-item">
                      <a class="nav-link" href="/">
                        <i class="fa-solid fa-house"></i> Home
                      </a>
                    </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
</nav>