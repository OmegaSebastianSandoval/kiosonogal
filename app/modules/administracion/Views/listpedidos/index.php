<h1 class="titulo-principal"><i class="fas fa-utensils"></i> Cocina - Pedidos Pendientes</h1>
<div class="container-fluid">
  <div class="content-dashboard">
    <div class="franja-paginas mb-4">
      <div class="row align-items-center">
        <div class="col-6">
          <div class="titulo-registro d-flex align-items-center">
            <i class="fas fa-clipboard-list text-secondary me-2"></i>
            Se encontraron <span class="badge bg-secondary"><?php echo count($this->pedidos); ?></span> pedidos listos
            para preparación
          </div>
        </div>
        <div class="col-6 text-end">
          <small class="text-muted">Última actualización: <span
              id="last-update"><?php echo date('H:i:s'); ?></span></small>
        </div>
      </div>
    </div>
    <div class="row">
      <?php foreach ($this->pedidos as $pedido) { ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card shadow-sm border-left-success">
            <div class="card-header bg-light">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="fas fa-shopping-cart text-secondary"></i> Pedido
                  #<?php echo $pedido->pedido_id; ?></h5>
                <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($pedido->pedido_fecha)); ?></small>
              </div>
            </div>
            <div class="card-body">
              <div class="cliente-info mb-3 p-2 bg-light rounded">
                <h6 class="text-secondary mb-2"><i class="fas fa-user"></i> Información del cliente</h6>
                <p class="mb-1"><strong>Nombre:</strong> <?php echo $pedido->pedido_nombre; ?></p>
                <p class="mb-1"><strong>Teléfono:</strong> <a href="tel:<?php echo $pedido->pedido_celular; ?>"
                    class="text-decoration-none"><?php echo $pedido->pedido_celular; ?></a></p>
                <p class="mb-1"><strong>Correo:</strong> <a href="mailto:<?php echo $pedido->pedido_correo; ?>"
                    class="text-decoration-none"><?php echo $pedido->pedido_correo; ?></a></p>
                <p class="mb-0"><strong>Lugar:</strong> <?php echo $pedido->pedido_lugar; ?></p>
              </div>
              <h6 class="text-secondary"><i class="fas fa-utensils"></i> Productos a preparar</h6>
              <div class="productos-list">
                <?php foreach ($pedido->productos as $producto) { ?>
                  <div class="d-flex align-items-center mb-2 p-2 border rounded">
                    <img src="/images/<?php echo $producto->pedido_producto_imagen; ?>" class="img-thumbnail me-3"
                      width="60" height="60" alt="<?php echo $producto->pedido_producto_nombre; ?>" />
                    <div class="flex-grow-1">
                      <strong><?php echo $producto->pedido_producto_nombre; ?></strong>
                    </div>
                    <span class="badge bg-success fs-6"><?php echo $producto->pedido_producto_cantidad; ?>x</span>
                  </div>
                <?php } ?>
              </div>
              <?php if ($pedido->pedido_observacion) { ?>
                <div class="alert alert-warning mt-3">
                  <strong><i class="fas fa-sticky-note"></i> Observación:</strong>
                  <?php echo $pedido->pedido_observacion; ?>
                </div>
              <?php } ?>
            </div>
            <div class="card-footer bg-transparent">
              <button class="btn btn-success btn-sm w-100" onclick="marcarPreparado(<?php echo $pedido->pedido_id; ?>)">
                <i class="fas fa-check-circle"></i> Marcar como Preparado
              </button>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<script>
  function marcarPreparado (id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¿Quieres marcar este pedido como preparado?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Sí, marcar como preparado',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?php echo $this->route; ?>/preparar?id=' + id;
      }
    });
  }

  setInterval(function () {
    location.reload();
  }, 15000);
</script>