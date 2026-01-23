<div class="detalle-carrito"
  style="position: static; width: 100%; height: auto; right: auto; top: auto; padding: 20px;">
  <div class="d-flex align-items-center justify-content-center">
    <i class="fas fa-credit-card icono-cart"></i>
    <h2 class="titulo-carrito">Pagar compra</h2>
  </div>
  <?php $valortotal = 0; ?>
  <?php if (count($this->carrito) > 0) { ?>
    <?php foreach ($this->carrito as $key => $carrito) { ?>
      <?php
      $producto = $carrito['detalle'];
      $valor = $carrito['cantidad'] * $producto->producto_precio;
      $valortotal = $valortotal + $valor;
      ?>
      <div class="row item-carrito">
        <div class="col-3 cajax">
          <img src="/images/<?php echo $producto->producto_imagen; ?>" alt="<?php echo $producto->producto_nombre; ?>">
        </div>
        <div class="col-6 cajax2">
          <h4 class="titulo-product-carrito"><?php echo $producto->producto_nombre; ?></h4>
          <div>Unid. <span
              style=" font-size: 14px;font-weight: 600;">$<?php echo number_format($producto->producto_precio, 0, ',', '.'); ?></span>
          </div>
          <div class="precio-product-carrito">Total: <span id="valortotal<?php echo $producto->producto_id; ?>"
              class="valortotal"
              style="font-size: 16px;font-weight: 700;">$<?php echo number_format($producto->producto_precio * $carrito['cantidad'], 0, ',', '.') ?></span>
          </div>
        </div>
        <div class="col-3 text-center">
          <div class="cantidad-display">Cantidad: <?php echo $carrito['cantidad']; ?></div>
        </div>
      </div>
    <?php } ?>
    <div class="row justify-content-between total-carrito">
      <div class="col-6 valor_pagar">
        Valor a pagar:
      </div>
      <div class="col-6 text-end">
        <div class="valor" id="totalpagar">$<?php echo number_format($valortotal, 0, ',', '.') ?></div>
      </div>

      <div class="col-12 mt-3">
        <div class="mb-3">
          <label class="form-label" style="color: var(--grisoscuro); font-weight: 600;">Seleccione método de pago</label>
          <div class="d-grid gap-2">
            <button class="btn btn-lg btn-outline-primary btn-metodo" data-metodo="efectivo">Efectivo (Caja)</button>
            <button class="btn btn-lg btn-outline-success btn-metodo" data-metodo="tarjeta">Tarjeta</button>
            <button class="btn btn-lg btn-outline-secondary btn-metodo" data-metodo="vale">Vale</button>
          </div>
        </div>
        <div class="pagar">
          <button id="btnPagar" class="btn btn-sm btn-primary-carrito">
            <i class="fas fa-credit-card me-2"></i>Pagar $<?php echo number_format($valortotal, 0, ',', '.') ?>
          </button>
        </div>
        <div class="pagar">
          <a href="/page/productos" class="btn btn-sm btn-primary-carrito-seguir">
            <i class="fas fa-shopping-bag me-2"></i>Seguir comprando
          </a>
        </div>
      </div>
    </div>

    <div id="pagoResult" class="mt-3" style="display:none"></div>


  <?php } else { ?>
    <div class="logo-alert" align="center">
      <img class="aloe" src="/corte/logonegro.png" height="120" alt="Logo Nogal">
    </div>
    <div class="mensaje-alert alert" align="center">
      <i class="fas fa-shopping-cart" style="font-size: 24px; margin-bottom: 10px;"></i>
      <p>No hay productos en tu carrito</p>
      <p style="font-size: 14px; color: var(--gris); margin-top: 10px;">¡Explora nuestro menú y agrega tus favoritos!</p>
    </div>
    <div class="pagar px-3">
      <a href="/page/productos" class="btn btn-sm btn-primary-carrito-seguir">
        <i class="fas fa-shopping-bag me-2"></i>Ver menú
      </a>
    </div>
  </div>
<?php } ?>