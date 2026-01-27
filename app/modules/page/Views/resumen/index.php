<div class="container contenedor-resumen">
  <div class="row justify-content-center">

    <div class="card shadow-lg border-0 rounded-4 p-0">
      <div class="card-header bg-gradient-primary text-white text-center rounded-top-4">
        <img src="/skins/page/images/logo.webp" alt="Logo" class="logo-resumen mb-3" style="max-width: 120px;">
        <h3 class="mb-0">Resumen del pedido</h3>
        <p class="mb-0">Pedido #<?php echo $this->pedido->pedido_id; ?></p>
      </div>
      <div class="card-body p-4">
        <!-- Contador de redirección -->
        <div id="redirect-message" class="alert alert-info text-center mb-4" style="display: none;">
          <i class="fas fa-clock me-2"></i>
          <span id="countdown-text">Volviendo al inicio en 30 segundos</span>
        </div>
        <!-- Detalles del cliente -->
        <div class="row mb-4 container-detalle-cliente">
          <div class="col-md-6">
            <div class="d-flex align-items-center mb-3">
              <i class="fas fa-user-circle  me-2"></i>
              <h5 class="mb-0 text-resumen">Información del cliente</h5>
            </div>
            <div class="bg-light p-3 rounded">
              <p class="mb-2"><span>Nombre:</span> <?php echo $this->pedido->pedido_nombre; ?></p>
              <p class="mb-2"><span>Documento:</span> <?php echo $this->pedido->pedido_documento; ?></p>
              <p class="mb-0"><span>Correo:</span> <?php echo $this->pedido->pedido_correo; ?></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center mb-3">
              <i class="fas fa-receipt  me-2"></i>
              <h5 class="mb-0 text-resumen">Detalles del pedido</h5>
            </div>
            <div class="bg-light p-3 rounded">
              <p class="mb-2"><span>Fecha:</span>
                <?php echo date('d/m/Y H:i', strtotime($this->pedido->pedido_fecha)); ?></p>
              <p class="mb-2"><span>Método de pago:</span> <span
                  class="badge text-bg-success"><?php echo $this->metodoPago; ?></span></p>
              <?php if ($this->pedido->pedido_cuotas): ?>
                <p class="mb-2"><span>Cuotas:</span> <?php echo $this->pedido->pedido_cuotas; ?></p>
              <?php endif; ?>
              <?php if ($this->pedido->pedido_lugar): ?>
                <p class="mb-0"><span>Lugar:</span> <?php echo $this->pedido->pedido_lugar; ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <!-- Estado del pedido -->
        <div class="alert alert-success mt-4 rounded-4 shadow-sm" role="alert">
          <div class="text-center">
            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
            <h5 class="alert-heading fw-bold">¡Pago exitoso!</h5>
            <p class="mb-2">Su pedido ha sido procesado correctamente con
              <strong><?php echo $this->metodoPago; ?></strong>.
            </p>
            <p class="mb-0">Enviado a preparación. ¡Gracias por su compra!</p>
          </div>
        </div>
        <!-- Lista de productos -->
        <div class="d-flex align-items-center mb-3">
          <i class="fas fa-utensils  me-2"></i>
          <h5 class="mb-0 text-resumen">Productos ordenados</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-primary">
              <tr>
                <th class="text-center">Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio unitario</th>
                <th class="text-center">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php $total = 0; ?>
              <?php foreach ($this->productos as $producto): ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="/images/<?php echo $producto->pedido_producto_imagen; ?>"
                        alt="<?php echo $producto->pedido_producto_nombre; ?>" class="rounded-circle me-3"
                        style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--grisclaro);">
                      <div>
                        <strong><?php echo $producto->pedido_producto_nombre; ?></strong>
                      </div>
                    </div>
                  </td>
                  <td class="text-center align-middle"><span
                      class="badge fs-6"><?php echo $producto->pedido_producto_cantidad; ?></span></td>
                  <td class="text-center align-middle">
                    $<?php echo number_format($producto->pedido_producto_valor + $producto->pedido_producto_valor_impuestos, 0, ',', '.'); ?>
                  </td>
                  <td class="text-center align-middle fw-bold">
                    $<?php echo number_format($producto->pedido_producto_valor_total, 0, ',', '.'); ?></td>
                </tr>
                <?php $total += $producto->pedido_producto_valor_total; ?>
              <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
              <tr>
                <th colspan="3" class="text-end fw-bold">Total a Pagar:</th>
                <th class="text-center fw-bold fs-5 text-success">$<?php echo number_format($total, 0, ',', '.'); ?>
                </th>
              </tr>
            </tfoot>
          </table>
        </div>


      </div>
      <div class="card-footer text-center bg-light rounded-bottom-4 h-auto min-h-auto">
        <a href="/page/index/logout" class="btn btn-primary rounded-pill px-4 my-1">Volver al menú</a>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const redirectMessage = document.getElementById('redirect-message');
    const countdownText = document.getElementById('countdown-text');
    let countdown = 30;

    // Mostrar el mensaje
    redirectMessage.style.display = 'block';

    const interval = setInterval(() => {
      countdown--;

      countdownText.textContent = `Volviendo al inicio en ${countdown} segundos`;

      if (countdown <= 0) {
        clearInterval(interval);
        window.location.href = '/page/index/logout';
      }
    }, 1000);
  });

</script>

<style>
  header {
    display: none;
  }
  .min-h-auto{
    min-height: auto !important;
  }
</style>