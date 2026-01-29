<div class="container-productos">
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-icon">
        <span class="material-symbols-outlined">
          <i class="fa-solid fa-utensils"></i>
        </span>
      </div>
    </div>

    <nav class="nav">
      <?php foreach ($this->categoriasList as $categoria): ?>
        <a href="/page/productos?categoria=<?php echo $categoria->categoria_id; ?>"
          class="nav-button <?php echo $categoria->categoria_id == $this->selectedCategoryId ? 'active' : ''; ?> ">
          <div class="nav-icon">
            <span class="material-symbols-outlined">
              <?php if ($categoria->categoria_icono):
                echo $categoria->categoria_icono;
                ?>
              <?php else: ?>
                <i class="fa-solid fa-bowl-food"></i>
              <?php endif ?>
            </span>
          </div>
          <span class="nav-label"><?php echo ($categoria->categoria_nombre); ?></span>
        </a>
      <?php endforeach; ?>

    </nav>


    <?php if ($this->socio && $this->socio->SBE_CODI): ?>

      <a class="info-button salir" data-bs-toggle="tooltip" data-bs-title="Salir" href="/page/index/logout">
        <span class="material-symbols-outlined">
          <i class="fa-solid fa-sign-out-alt"></i>
          Salir
        </span>
      </a>
    <?php else: ?>

      <a class="info-button home" data-bs-toggle="tooltip" data-bs-title="Home" href="/">
        <span class="material-symbols-outlined"> <i class="fa-solid fa-house"></i>Home</span>
      </a>
    <?php endif; ?>
  </aside>

  <main class="main-content">
    <!-- Header -->
    <header class="header d-flex align-items-center justify-content-between">
      <div>
        <?php if (!$this->socio || !$this->socio->SBE_CODI): ?>

          <div class="login-container">
            <h4 class="login-title">BIENVENIDO</h4>
            <form id="formCarnet" class="login-form">
              <input type="hidden" name="hash" value="<?php echo $this->_view->securityHash; ?>">
              <div class="form-group">
                <label for="numeroCarnet" class="form-label">N&uacute;mero de carnet</label>
                <div class="input-button-container">
                  <input type="number" class="keyboard-input form-control login-input" id="numeroCarnet"
                    name="numeroCarnet" placeholder="Ej. 12345678" data-kioskboard-type="numpad">
                  <button class="totem-btn totem-btn-primary submit-btn" type="submit"><i
                      class="fa fa-arrow-right"></i></button>
                </div>
              </div>
              <input type="hidden" name="hash" value="<?= $this->securityHash ?>">
            </form>
          </div>
        <?php else: ?>
          <div class="container-info p-0">
            <h4>Bienvenido, <span><?php echo ($this->socio->sbe_nomb . " " . $this->socio->sbe_apel); ?></span></h4>
          </div>
        <?php endif; ?>


        <div class="header-content">
          <div>
            <p class="header-subtitle">Nuestra selecci&oacute;n</p>
            <h2 class="header-title">
              <?php echo $this->categoriaInfo ? ($this->categoriaInfo->categoria_nombre) : "Todos los productos"; ?>
            </h2>
          </div>

        </div>
      </div>

      <div class="h-100 d-flex flex-column justify-content-between align-items-end gap-3">
        <div class="d-flex align-items-center gap-2 h-100"> <img src="/skins/page/images/logo-hd.png"
            alt="Logo club el nogal" style="height: 68px;" class="">
        </div>
        <div class="dropdown mt-auto">
          <button class="filter-button dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
            aria-expanded="false">
            <span class="material-symbols-outlined"><i class="fa-solid fa-filter"></i></span>
            <span>Filtro</span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a
                class="dropdown-item filter-option <?php echo ($this->selectedOrden == 'destacado') ? 'active' : ''; ?>"
                href="#" data-orden="destacado">Destacados primero</a></li>
            <li><a
                class="dropdown-item filter-option <?php echo ($this->selectedOrden == 'nombre_asc') ? 'active' : ''; ?>"
                href="#" data-orden="nombre_asc">Nombre A-Z</a></li>
            <li><a
                class="dropdown-item filter-option <?php echo ($this->selectedOrden == 'nombre_desc') ? 'active' : ''; ?>"
                href="#" data-orden="nombre_desc">Nombre Z-A</a></li>
            <li><a
                class="dropdown-item filter-option <?php echo ($this->selectedOrden == 'precio_asc') ? 'active' : ''; ?>"
                href="#" data-orden="precio_asc">Precio menor a mayor</a></li>
            <li><a
                class="dropdown-item filter-option <?php echo ($this->selectedOrden == 'precio_desc') ? 'active' : ''; ?>"
                href="#" data-orden="precio_desc">Precio mayor a menor</a></li>
          </ul>
        </div>
      </div>

    </header>

    <!-- Scrollable Grid Area -->
    <div class="grid-container">
      <div class="product-grid">
        <!-- Product Card 1 -->
        <?php foreach ($this->productos as $producto): ?>
          <div class="product-card">
            <div class="product-image-container">
              <div class="product-image"
                style="background-image: url('/images/<?php echo ($producto->producto_imagen); ?>');" type="button"
                data-bs-toggle="modal" data-bs-target="#modal-<?php echo (int) $producto->producto_id; ?>">
              </div>
              <button type="button" data-bs-toggle="modal"
                data-bs-target="#modal-<?php echo (int) $producto->producto_id; ?>" class="info-icon">
                <span class="material-symbols-outlined"><i class="fa-solid fa-circle-info"></i></span>
              </button>
              <?php if ($producto->producto_nuevo): ?>
                <div class="new-badge">Nuevo</div>
              <?php endif ?>
            </div>
            <div class="product-content">
              <h3 class="product-title"><?php echo ($producto->producto_nombre); ?></h3>
              <div class="product-description"><?php echo ($producto->producto_descripcion); ?></div>
              <div class="product-footer">
                <span class="product-price">$<?php echo number_format((float) $producto->producto_precio, 0); ?></span>
                <?php if ($this->socio && $this->socio->SBE_CODI): ?>
                  <button class="add-button btn-agregar-carrito" data-producto="<?php echo (int) $producto->producto_id; ?>"
                    data-cantidad="1">
                    Agregar
                    <span class="material-symbols-outlined"><i class="fa-solid fa-plus"></i></span>
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- MODAL -->

          <div class="modal fade modal-product" id="modal-<?php echo (int) $producto->producto_id; ?>" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header border-0 ">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                  <img src="/images/<?php echo ($producto->producto_imagen); ?>"
                    alt="<?php echo ($producto->producto_nombre); ?>">
                  <h3><?php echo ($producto->producto_nombre); ?></h3>
                  <div><?php echo ($producto->producto_descripcion); ?></div>
                  <div class="d-flex justify-content-between align-items-center mt-3 gap-2">

                    <p class="price">$<?php echo number_format((float) $producto->producto_precio, 0); ?></p>
                    <?php if ($this->socio && $this->socio->SBE_CODI): ?>
                      <button type="button" class="btn-agregar-carrito"
                        data-producto="<?php echo (int) $producto->producto_id; ?>" data-cantidad="1">Agregar al
                        carrito</button>
                    <?php else: ?>
                      <div class="alert alert-light mb-0" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <span class="fs-6">

                          Para agregar productos al carrito, por favor inicia sesi&oacute;n. </span>
                      </div>

                    <?php endif; ?>
                  </div>
                  <!-- <p class="code">Código: <?php
                  // echo ($producto->producto_codigo); 
                  ?></p> -->
                </div>

                <!--<div class="modal-footer border-0 pt-0">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>  </div>-->
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php if ($this->socio && $this->socio->SBE_CODI): ?>

      <!-- Sticky Bottom Checkout Bar -->
      <div class="checkout-bar">
        <div class="checkout-content">
          <div class="order-thumbnails" style="display: none;">
            <div class="thumbnail"></div>
            <div class="thumbnail-count"></div>
          </div>
          <div class="order-info">
            <p class="order-label">Tu orden</p>
            <p class="order-count"></p>
          </div>
          <button class="view-order-button">
            <span>Ver orden</span>
            <span class="button-divider"></span>
            <span></span>
          </button>
        </div>
      </div>
    <?php endif; ?>

  </main>
</div>
<?php if ($this->socio && $this->socio->SBE_CODI): ?>

  <!-- Modal Carrito -->
  <div class="modal fade modal-carrito" id="carrito-modal" tabindex="-1" role="dialog" aria-labelledby="carritoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="carritoModalLabel"><i class="fas fa-shopping-cart icono-cart"></i> Carrito de
            compras</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Contenido cargado dinámicamente -->
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php if ($this->popup->publicidad_estado == 1 && $_GET['popup'] == 1) { ?>
  <? ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const popup = document.getElementById("popup");
      if (popup) {
        const modal = new bootstrap.Modal(popup);
        modal.show();
      }
    });
  </script>
<?php } ?>
<!-- Modal PopUp -->
<?php if ($this->popup->publicidad_estado == 1 && $_GET['popup'] == 1) { ?>
  <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style=" border: none;
    background-color: transparent;">
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"
          style="filter: invert(1);"></button>
        <div class="modal-body">
          <?php if ($this->popup->publicidad_video != "") { ?>
            <div class="fondo-video-youtube">
              <div class="banner-video-youtube" id="videobanner<?php echo $this->popup->publicidad_id; ?> "
                data-video="<?php echo $this->id_youtube($this->popup->publicidad_video); ?>"></div>
            </div>
          <?php } ?>
          <?php if ($this->popup->publicidad_imagen != "") { ?>
            <?php if ($this->popup->publicidad_enlace != "") { ?> <a href="<?php echo $this->popup->publicidad_enlace ?>"
                <?php if ($this->popup->publicidad_tipo_enlace == 1) {
                  echo "target='_blank'";
                } ?>> <?php } ?><img
                class="w-100 img-fluid d-none d-md-block img-popup"
                src="/images/<?php echo $this->popup->publicidad_imagen ?>"
                alt="Imagen PopUp <?= $this->popup->publicidad_nombre ?>">
              <img class="w-100 img-fluid d-block d-md-none" src="/images/<?php echo $this->popup->publicidad_imagen ?>"
                alt="Imagen PopUp <?= $this->popup->publicidad_nombre ?>">
              <?php if ($this->popup->publicidad_enlace != "") { ?>
              </a>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const productGrid = document.querySelector('.product-grid');
    if (productGrid && productGrid.children.length === 2) {
      productGrid.classList.add('single');
    }

    // Manejar clicks en las opciones de filtro
    document.querySelectorAll('.filter-option').forEach(function (element) {
      element.addEventListener('click', function (e) {
        e.preventDefault();
        const orden = this.getAttribute('data-orden');
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('orden', orden);
        window.location.href = window.location.pathname + '?' + urlParams.toString();
      });
    });
  });
</script>