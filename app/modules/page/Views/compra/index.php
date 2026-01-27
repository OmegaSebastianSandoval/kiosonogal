<div class="detalle-carrito detalle-compra ">
  <div class="d-flex align-items-center justify-content-center  header-carrito">
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
            <div>Valor unitario: <span>$<?php echo number_format($producto->producto_precio, 0, ',', '.'); ?></span>
            </div>
            <div class="precio-product-carrito">Total: <span id="valortotal<?php echo $producto->producto_id; ?>"
                class="valortotal">$<?php echo number_format($producto->producto_precio * $carrito['cantidad'], 0, ',', '.') ?></span>
            </div>
          </div>
          <div class="col-3 text-end">
            <div class="cantidad-display">Cantidad: <span>

                <?php echo $carrito['cantidad']; ?> </span></div>
          </div>
        </div>
      <?php } ?>
      <div class="row justify-content-end total-carrito">

        <div class="col-6 text-end justify-content-end d-flex align-items-center gap-2">
          <span class="valor_pagar">
            Valor a pagar:

          </span>
          <div class="valor" id="totalpagar">$<?php echo number_format($valortotal, 0, ',', '.') ?></div>
        </div>

        <div class="col-12 ">
          <div class="mb-2">
            <label class="form-label seleccion-metodo">Seleccione método de
              pago</label>
            <div class="d-grid gap-2 max-w-600">


              <a href="#" class="btn btn-lg btn-primary-carrito-datafono btn-metodo"><i
                  class="fas fa-credit-card me-2"></i>Pagar
                con datáfono</a>

              <?php if ($this->socio && $this->socio->SBE_CODI && $this->socio->SBE_CUPO) { ?>
                <button type="button" class="btn btn-lg btn-primary-carrito btn-metodo" data-bs-toggle="modal"
                  data-bs-target="#modalCargo">
                  <i class="fas fa-money-bill-wave me-2"></i>Pagar con cargo a la acción
                </button>
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

    <!-- Modal -->
    <div class="modal fade" id="modalCargo" tabindex="-1" aria-labelledby="modalCargoLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCargoLabel">Confirmar pago con cargo a la acción</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/page/pagar/cargo" method="post" id="formCarritoCargo" novalidate>
              <h6>Resumen del pedido:</h6>
              <ul>
                <?php foreach ($this->carrito as $carrito) { ?>
                  <li class="resumen-item">
                    <span class="producto-nombre"><?php echo $carrito['detalle']->producto_nombre; ?></span>
                    <span class="producto-cantidad">(Cant: <?php echo $carrito['cantidad']; ?>)</span>
                    <span
                      class="producto-precio">$<?php echo number_format($carrito['cantidad'] * $carrito['detalle']->producto_precio, 0, ',', '.'); ?></span>
                  </li>
                <?php } ?>
              </ul>
              <p><strong>Total: $<?php echo number_format($valortotal, 0, ',', '.'); ?></strong></p>
              <div class="mb-3">
                <label for="cuotas">Selecciona el número de cuotas:</label>
                <select id="cuotas" name="cuotas" class="form-select" required>
                  <option value="">Selecciona...</option>
                  <option value="1">1 cuota</option>
                  <option value="2">2 cuotas</option>
                  <option value="3">3 cuotas</option>
                  <option value="4">4 cuotas</option>
                  <option value="5">5 cuotas</option>
                  <option value="6">6 cuotas</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="lugar">Selecciona el lugar en el que se encuentra (1 a 16):</label>
                <input type="number" id="lugar" name="lugar" class="form-control" min="1" max="16" required>
              </div>
              <div id="errorMessages" class="alert alert-danger mt-3" style="display:none;"></div>
              <div class="modal-footer d-flex gap-3 ">
                <button type="submit" class="btn btn-primary-carrito  ">Aceptar y Pagar</button>
                <button type="button" class="btn btn-secondary btn-metodo " data-bs-dismiss="modal">Cancelar</button>


              </div>
            </form>

          </div>
        </div>
      </div>
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
<script>
  document.getElementById('formCarritoCargo').addEventListener('submit', function (e) {
    e.preventDefault();
    const cuotas = document.getElementById('cuotas').value;
    const lugarValue = document.getElementById('lugar').value;
    const lugar = parseInt(lugarValue, 10);
    let valid = true;
    let errors = [];
    if (!cuotas) {
      errors.push('Por favor, selecciona el número de cuotas.');
      valid = false;
    }
    if (!lugarValue || isNaN(lugar) || lugar < 1 || lugar > 16) {
      errors.push('Por favor, ingresa un lugar válido entre 1 y 16.');
      valid = false;
    }
    if (valid) {
      document.getElementById('errorMessages').style.display = 'none';
      this.submit();
    } else {
      const errorDiv = document.getElementById('errorMessages');
      errorDiv.innerHTML = '<ul>' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul>';
      errorDiv.style.display = 'block';
    }
  });
</script>

<style>
  header {
    display: none;
  }
</style>