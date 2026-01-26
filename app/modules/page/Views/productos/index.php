<div class="container container-productos">
  <?php if (!$this->socio || !$this->socio->SBE_CODI): ?>
    <div class="contenedor-consulta-socio">
      <h4>BIENVENIDO</h4>
      <form id="formCarnet">
        <input type="hidden" name="hash" value="<?php echo $this->_view->securityHash; ?>">
        <div class="mb-3">
          <label for="numeroCarnet" class="form-label">Número de carnet</label>
          <div class="input-container">
            <input type="number" class="form-control input-with-button" id="numeroCarnet" name="numeroCarnet"
              placeholder="Ej. 12345678" required>
            <button class="btn-inside" type="submit"><i class="fa fa-arrow-right"></i></button>
          </div>
          <input type="hidden" name="hash" value="<?= $this->securityHash ?>">
        </div>
      </form>
    </div>
  <?php endif; ?>
  <?php if ($this->socio && $this->socio->SBE_CODI): ?>
    <div class="container-info">

      <h4>HOLA, <span><?php echo htmlspecialchars($this->socio->sbe_nomb . " " . $this->socio->sbe_apel); ?></span></h4>
    </div>

  <?php endif; ?>

  <?php if ($this->selectedCategoryId): ?>
    <div class="show-all-button" style="text-align: center; margin: 20px 0;">
      <a href="/page/productos" class="totem-btn totem-btn-secondary">Mostrar todos los productos</a>
    </div>
  <?php endif; ?>

  <?php if (is_countable($this->productosDestacados) && count($this->productosDestacados) > 0): ?>
    <h2>PRODUCTOS DESTACADOS</h2>
    <div class="product-grid">
      <?php foreach ($this->productosDestacados as $producto): ?>

        <a href="#modal-<?php echo (int) $producto->producto_id; ?>" class="product-card">
          <img src="/images/<?php echo htmlspecialchars($producto->producto_imagen); ?>"
            alt="<?php echo htmlspecialchars($producto->producto_nombre); ?>">
          <div class="product-info">

            <h4><?php echo htmlspecialchars($producto->producto_nombre); ?></h4>
            <?php if ($this->socio && $this->socio->SBE_CODI): ?>
              <button type="button" class="totem-btn totem-btn-primary w-100 btn-agregar-carrito"
                data-producto="<?php echo (int) $producto->producto_id; ?>" data-cantidad="1">AGREGAR</button>
            <?php endif; ?>
          </div>

          <div class="badges">
            <?php if ((int) $producto->producto_destacado === 1): ?>
              <span class="badge featured">Destacado</span>
            <?php endif; ?>
            <?php if ((int) $producto->producto_nuevo === 1): ?>
              <span class="badge new">Nuevo</span>
            <?php endif; ?>
          </div>
        </a>

        <!-- MODAL -->
        <div id="modal-<?php echo (int) $producto->producto_id; ?>" class="product-modal">
          <div class="modal-content">
            <a href="#" class="close">&times;</a>

            <img src="/images/<?php echo htmlspecialchars($producto->producto_imagen); ?>"
              alt="<?php echo htmlspecialchars($producto->producto_nombre); ?>">
            <h3><?php echo htmlspecialchars($producto->producto_nombre); ?></h3>
             <div><?php echo ($producto->producto_descripcion); ?></div>
            <p class="price">$<?php echo number_format((float) $producto->producto_precio); ?></p>
            <p class="code">Código: <?php echo htmlspecialchars($producto->producto_codigo); ?></p>

            <?php if ($this->socio && $this->socio->SBE_CODI): ?>
              <button type="button" class="btn-agregar-carrito" data-producto="<?php echo (int) $producto->producto_id; ?>"
                data-cantidad="1">Agregar al carrito</button>
            <?php endif; ?>
          </div>
        </div>

      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (is_countable($this->productosNormales) && count($this->productosNormales) > 0): ?>
    <h2>PRODUCTOS NORMALES</h2>

    <div class="product-grid">
      <?php foreach ($this->productosNormales as $producto): ?>

        <a href="#modal-<?php echo (int) $producto->producto_id; ?>" class="product-card">
          <img src="/images/<?php echo htmlspecialchars($producto->producto_imagen); ?>"
            alt="<?php echo htmlspecialchars($producto->producto_nombre); ?>">
          <div class="product-info">

            <h4><?php echo htmlspecialchars($producto->producto_nombre); ?></h4>
            <?php if ($this->socio && $this->socio->SBE_CODI): ?>
              <button type="button" class="totem-btn totem-btn-primary w-100 btn-agregar-carrito"
                data-producto="<?php echo (int) $producto->producto_id; ?>" data-cantidad="1">AGREGAR</button>
            <?php endif; ?>
          </div>

          <div class="badges">
            <?php if ((int) $producto->producto_destacado === 1): ?>
              <span class="badge featured">Destacado</span>
            <?php endif; ?>
            <?php if ((int) $producto->producto_nuevo === 1): ?>
              <span class="badge new">Nuevo</span>
            <?php endif; ?>
          </div>
        </a>

        <!-- MODAL -->
        <div id="modal-<?php echo (int) $producto->producto_id; ?>" class="product-modal">
          <div class="modal-content">
            <a href="#" class="close">&times;</a>

            <img src="/images/<?php echo htmlspecialchars($producto->producto_imagen); ?>"
              alt="<?php echo htmlspecialchars($producto->producto_nombre); ?>">
            <h3><?php echo htmlspecialchars($producto->producto_nombre); ?></h3>
            <div><?php echo ($producto->producto_descripcion); ?></div>
            <p class="price">$<?php echo number_format((float) $producto->producto_precio, 2); ?></p>
            <p class="code">Código: <?php echo htmlspecialchars($producto->producto_codigo); ?></p>

            <?php if ($this->socio && $this->socio->SBE_CODI): ?>
              <button type="button" class="btn-agregar-carrito" data-producto="<?php echo (int) $producto->producto_id; ?>"
                data-cantidad="1">Agregar al carrito</button>
            <?php endif; ?>
          </div>
        </div>

      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="container-info">
      <h4>No hay productos disponibles en esta categoría.</h4>
    </div>
  <?php endif; ?>

</div>

<?php if ($this->socio && $this->socio->SBE_CODI): ?>
  <div class="btn-carrito-flotante">
  
    <i class="fas fa-shopping-cart"></i>
    <span class="badge-cantidad" style="display: none;">0</span>
  </div>

  <div class="caja-carrito">
    <div class="carrito-overlay"></div>
    <div class="detalle-carrito">
      <div class="btn-cerrar-carrito">
        <i class="fas fa-times"></i>
      </div>
      <div id="micarrito" class="container p-0">
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