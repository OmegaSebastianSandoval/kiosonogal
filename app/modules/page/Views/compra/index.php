<div class="detalle-carrito detalle-compra">
  <div class="d-flex align-items-center justify-content-center">
    <i class="fas fa-credit-card icono-cart"></i>
    <h2 class="titulo-carrito">Pagar compra</h2>
  </div>
  <div class="container fondo-carrito">

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
          <div class="col-3 text-end">
            <div class="cantidad-display">Cantidad: <span>

                <?php echo $carrito['cantidad']; ?> </span></div>
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

        <div class="col-12 mt-5">
          <div class="mb-2">
            <label class="form-label seleccion-metodo">Seleccione método de
              pago</label>
            <div class="d-grid gap-2 max-w-600">


              <button class="btn btn-lg btn-outline-success btn-metodo" data-metodo="datafono"><i
                  class="fas fa-credit-card me-2"></i>Datáfono</button>

              <?php if ($this->socio && $this->socio->SBE_CODI && $this->socio->SBE_CUPO) { ?>
                <a class="btn btn-lg btn-primary-carrito-cargo  btn-metodo" data-metodo="cargo" href="/page/pagar"><i
                    class="fas fa-money-bill-wave me-2"></i>Cargo a
                  la
                  acción</a>
              <?php } ?>


            </div>
          </div>
          <a href="/page/productos" class="btn btn-sm btn-seguir btn-outline-secondary">
            <i class="fas fa-shopping-bag me-2"></i>Seguir comprando
          </a>
        </div>
      </div>

      <div id="pagoResult" class="mt-3" style="display:none"></div>

    </div>

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
<style>
  header {
    display: none;
  }
</style>