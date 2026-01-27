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
            <span class="material-symbols-outlined"><i class="fa-solid fa-bowl-food"></i></span>
          </div>
          <span class="nav-label"><?php echo htmlspecialchars($categoria->categoria_nombre); ?></span>
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
    <?php if (!$this->socio || !$this->socio->SBE_CODI): ?>

      <div class="login-container">
        <h4 class="login-title">BIENVENIDO</h4>
        <form id="formCarnet" class="login-form">
          <input type="hidden" name="hash" value="<?php echo $this->_view->securityHash; ?>">
          <div class="form-group">
            <label for="numeroCarnet" class="form-label">Número de carnet</label>
            <div class="input-button-container">
              <input type="number" class="form-control login-input" id="numeroCarnet" name="numeroCarnet"
                placeholder="Ej. 12345678" required>
              <button class="totem-btn totem-btn-primary submit-btn" type="submit"><i
                  class="fa fa-arrow-right"></i></button>
            </div>
          </div>
          <input type="hidden" name="hash" value="<?= $this->securityHash ?>">
        </form>
      </div>
    <?php else: ?>
      <div class="container-info">
        <h4>Hola, <span><?php echo htmlspecialchars($this->socio->sbe_nomb . " " . $this->socio->sbe_apel); ?></span></h4>
      </div>
    <?php endif; ?>

    <!-- Header -->
    <header class="header">
      <div class="header-content">
        <div>
          <p class="header-subtitle">Nuestra selección</p>
          <h2 class="header-title">
            <?php echo $this->categoriaInfo ? htmlspecialchars($this->categoriaInfo->categoria_nombre) : "Todos los productos"; ?>
          </h2>
        </div>
        <button class="filter-button">
          <span class="material-symbols-outlined"><i class="fa-solid fa-filter"></i></span>
          <span>Filtro</span>
        </button>
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
                style="background-image: url('/images/<?php echo htmlspecialchars($producto->producto_imagen); ?>');"
                type="button" data-bs-toggle="modal" data-bs-target="#modal-<?php echo (int) $producto->producto_id; ?>">
              </div>
              <button type="button" data-bs-toggle="modal"
                data-bs-target="#modal-<?php echo (int) $producto->producto_id; ?>" class="info-icon">
                <span class="material-symbols-outlined"><i class="fa-solid fa-circle-info"></i></span>
              </button>
            </div>
            <div class="product-content">
              <h3 class="product-title"><?php echo htmlspecialchars($producto->producto_nombre); ?></h3>
              <div class="product-description"><?php echo ($producto->producto_descripcion); ?></div>
              <div class="product-footer">
                <span class="product-price">$<?php echo number_format((float) $producto->producto_precio, 0); ?></span>
                <?php if ($this->socio && $this->socio->SBE_CODI): ?>
                  <button class="add-button btn-agregar-carrito" data-producto="<?php echo (int) $producto->producto_id; ?>"
                    data-cantidad="1">
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
                  <img src="/images/<?php echo htmlspecialchars($producto->producto_imagen); ?>"
                    alt="<?php echo htmlspecialchars($producto->producto_nombre); ?>">
                  <h3><?php echo htmlspecialchars($producto->producto_nombre); ?></h3>
                  <div><?php echo ($producto->producto_descripcion); ?></div>
                  <div class="d-flex justify-content-between align-items-center mt-3">

                    <p class="price">$<?php echo number_format((float) $producto->producto_precio, 0); ?></p>
                    <?php if ($this->socio && $this->socio->SBE_CODI): ?>
                      <button type="button" class="btn-agregar-carrito"
                        data-producto="<?php echo (int) $producto->producto_id; ?>" data-cantidad="1">Agregar al
                        carrito</button>
                    <?php endif; ?>

                  </div>
                  <!-- <p class="code">Código: <?php
                  // echo htmlspecialchars($producto->producto_codigo); 
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
          <div class="order-thumbnails">
            <div class="thumbnail"
              style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBA3TFkB66oiBsseR1H_CwJfHMcxWILc1yJb3-gZBlgX6dnspmM_uRzIxDb8NjRBZNpeVeYbA_EngATiUv-8QB57R8NVYRAhuitNU5rFyOB3T0WnVVCfO-wIV-d5qsfbv-gxisrQheU19WEdihEQYwoaOadiMWH8EyrDWislEGqn7XfncUw2KvyMyAuDZv3UL7CshnH09cshS2Z01EAnyFvoiQR4mpCEJR6plVABrRog70HSwhGCoB74kyqF_EhSUnxdmdFr1Sp7rk');">
            </div>
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
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="carritoModalLabel"><i class="fas fa-shopping-cart icono-cart"></i> Carrito de
            Compras</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Contenido cargado dinámicamente -->
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const productGrid = document.querySelector('.product-grid');
    if (productGrid && productGrid.children.length === 2) {
      productGrid.classList.add('single');
    }
  });
</script>