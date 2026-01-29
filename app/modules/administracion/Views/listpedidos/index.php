<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Inter', sans-serif;
    background-color: #F4F6F8;
    margin: 0;
    color: #1F2933;
  }

  .panel {
    max-width: 100% !important;
    width: 100%;
  }

  .titulo-principal {
    text-align: center;
    font-size: 1rem;
    font-weight: 700;
    color: #1F3A5F;
    margin-bottom: 30px;
  }

  .container-fluid {
    max-width: 1400px;
    margin: 0 auto;
  }

  .row {
    display: flex;
    gap: 5px;
    justify-content: space-between;
  }

  .col-md-3 {
    flex: 1;
    /* min-width: 300px; */
    width: 100%;
  }

  .column-header {
    text-align: center;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 14px;
    color: white;
  }

  .column-header.listos {
    background-color: #1F3A5F;
  }

  .column-header.preparando {
    background-color: #F5A623;
  }

  .column-header.preparados {
    background-color: #2FBF71;
  }

  .column-header.entregados {
    background-color: #6B7280;
  }

  .card {
    background-color: #FFFFFF;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
  }

  .card-header {
    padding: 10px;
    border-bottom: 1px solid #E5E7EB;
    position: relative;
  }

  .card-header.listos {
    border-top: 4px solid #1F3A5F;
  }

  .card-header.preparando {
    border-top: 4px solid #F5A623;
  }

  .card-header.preparados {
    border-top: 4px solid #2FBF71;
  }

  .card-header.entregados {
    border-top: 4px solid #6B7280;
  }

  .card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1F2933;
    margin: 0;
  }

  .card-title span {
    background-color: #1F3A5F;
    padding: 3px;
    border-radius: 5px;
    color: #FFF;
    font-weight: 800;
    font-size: 1.3rem;

  }
  .card-time {
    font-size: 1rem;
    color: #6B7280;
  }

  .card-body {
    padding: 10px;
  }

  .badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
  }

  .badge.listos {
    background-color: #1F3A5F;
    color: white;
  }

  .badge.preparando {
    background-color: #F5A623;
    color: white;
  }

  .badge.preparados {
    background-color: #2FBF71;
    color: white;
  }

  .badge.entregados {
    background-color: #6B7280;
    color: white;
  }

  .cliente-info {
    background-color: #F9FAFB;
    padding: 5px;
    border-radius: 8px;
    margin-bottom: 16px;
    border: 1px solid #E5E7EB;
  }

  .cliente-info h6 {
    font-size: 0.6rem;
    color: #6B7280;
    margin-bottom: 8px;
    text-transform: uppercase;
    font-weight: 600;
  }

  .cliente-info p {
    margin: 4px 0;
    font-size: 0.9rem;
    color: #1F2933;
  }

  .productos-list {
    margin-bottom: 0px;
    padding: 0;
  }

  .productos-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #E5E7EB;
  }

  .productos-list li:last-child {
    border-bottom: none;
  }

  .producto-cantidad {
    font-weight: 700;
    color: #1F3A5F;
    font-size: 1.1rem;
  }

  .producto-nombre {
    flex: 1;
    margin-left: 8px;
    font-weight: 500;
  }

  .observacion {
    background-color: #F3F4F6;
    padding: 10px;
    border-radius: 8px;
    border-left: 4px solid #F5A623;
    font-size: 0.9rem;
    color: #1F2933;
  }

  .tiempo-transcurrido {
    font-size: 1rem;
    font-weight: 600;
    margin-top: 8px;
  }

  .tiempo-normal {
    color: #2C4E7A;
  }

  .tiempo-alto {
    color: #F5A623;
  }

  .tiempo-urgente {
    color: #E5533D;
    animation: blink 1s infinite;
  }

  @keyframes blink {

    0%,
    50% {
      opacity: 1;
    }

    51%,
    100% {
      opacity: 0.5;
    }
  }

  .card-footer {
    padding: 10px;
    background-color: #FFFFFF;
    border-top: 1px solid #E5E7EB;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .btn {
    border: none;
    border-radius: 8px;
    font-size: 0.6rem;
    font-weight: 600;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 10px 0;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }

  .btn-empezar {
    background-color: #2C4E7A;
    color: white;
    width: 100%;
  }

  .btn-preparado {
    background-color: #2FBF71;
    color: white;
    width: 70%;
  }

  .btn-entregado {
    background-color: #6B7280;
    color: white;
    width: 70%;

  }

  .btn-revertir {
    background-color: #F5A623;
    color: white;
    width: 25%;
    font-size: 0.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .tipo-badge {
    background-color: #E5E7EB;
    color: #1F2933;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
  }

  .contenedor {
    padding: 0 1rem 2rem 1rem;
  }

  .productos-text {
    color: #1F2933;
    margin-bottom: 12px;
    font-weight: 600;
    font-size: 1rem;
  }
</style>

<h1 class="titulo-principal"><i class="fas fa-utensils"></i> Kitchen Display System</h1>
<div class="contenedor">
  <div class="row g-0">
    <!-- Columna 1: LISTO PARA PREPARAR -->
    <div class="col-md-3">
      <h3 class="column-header listos">LISTO PARA PREPARAR</h3>
      <div id="listos-column">
        <?php foreach ($this->pedidos_listos as $pedido) { ?>
          <div class="card">
            <div class="card-header listos">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <h5 class="card-title">Pedido <span>#<?php echo $pedido->pedido_id; ?></span></h5>
                <small class="card-time"><?php echo date('H:i', strtotime($pedido->pedido_fecha)); ?></small>
              </div>
              <div style="margin-top: 8px;">
                <span class="badge listos">Listo para preparar</span>
                <!-- <span
                  class="tipo-badge"><?php echo ($pedido->pedido_lugar == 'Kiosko') ? 'Kiosko' : (($pedido->pedido_lugar == 'Mesa') ? 'Mesa' : 'Delivery'); ?></span> -->
              </div>
            </div>
            <div class="card-body">
              <div class="cliente-info">
                <h6><i class="fas fa-user"></i> Cliente</h6>
                <p><strong><?php echo $pedido->pedido_nombre; ?></strong></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $pedido->pedido_lugar; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $pedido->pedido_celular; ?></p>
              </div>
              <h6 class="productos-text">Productos</h6>
              <ul class="productos-list">
                <?php foreach ($pedido->productos as $producto) { ?>
                  <li>
                    <span class="producto-cantidad"><?php echo $producto->pedido_producto_cantidad; ?>x</span>
                    <span class="producto-nombre"><?php echo $producto->pedido_producto_nombre; ?></span>
                  </li>
                <?php } ?>
              </ul>
              <?php if ($pedido->pedido_observacion) { ?>
                <div class="observacion">
                  <i class="fas fa-sticky-note"></i> <?php echo $pedido->pedido_observacion; ?>
                </div>
              <?php } ?>
            </div>
            <div class="card-footer">
              <button class="btn btn-empezar" onclick="iniciarPreparacion(<?php echo $pedido->pedido_id; ?>)">
                <i class="fas fa-play"></i> EMPEZAR
              </button>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <!-- Columna 2: EN PREPARACIÓN -->
    <div class="col-md-3">
      <h3 class="column-header preparando">EN PREPARACIÓN</h3>
      <div id="preparando-column">
        <?php foreach ($this->pedidos_preparando as $pedido) {
          $tiempo_transcurrido = time() - strtotime($pedido->pedido_fecha);
          $minutos = floor($tiempo_transcurrido / 60);
          $segundos = $tiempo_transcurrido % 60;
          $tiempo_class = ($minutos > 10) ? 'tiempo-urgente' : (($minutos > 5) ? 'tiempo-alto' : 'tiempo-normal');
          ?>
          <div class="card">
            <div class="card-header preparando">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <h5 class="card-title">Pedido <span>#<?php echo $pedido->pedido_id; ?></span></h5>
                <small class="card-time"><?php echo date('H:i', strtotime($pedido->pedido_fecha)); ?></small>
              </div>
              <div style="margin-top: 8px;">
                <span class="badge preparando">Preparando</span>
                <!-- <span
                  class="tipo-badge"><?php echo ($pedido->pedido_lugar == 'Kiosko') ? 'Kiosko' : (($pedido->pedido_lugar == 'Mesa') ? 'Mesa' : 'Delivery'); ?></span> -->
              </div>
              <div class="tiempo-transcurrido <?php echo $tiempo_class; ?>">
                Tiempo: <?php echo $minutos; ?>m <?php echo $segundos; ?>s
              </div>
            </div>
            <div class="card-body">
              <div class="cliente-info">
                <h6><i class="fas fa-user"></i> Cliente</h6>
                <p><strong><?php echo $pedido->pedido_nombre; ?></strong></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $pedido->pedido_lugar; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $pedido->pedido_celular; ?></p>
              </div>
              <h6 class="productos-text">Productos</h6>
              <ul class="productos-list">
                <?php foreach ($pedido->productos as $producto) { ?>
                  <li>
                    <span class="producto-cantidad"><?php echo $producto->pedido_producto_cantidad; ?>x</span>
                    <span class="producto-nombre"><?php echo $producto->pedido_producto_nombre; ?></span>
                  </li>
                <?php } ?>
              </ul>
              <?php if ($pedido->pedido_observacion) { ?>
                <div class="observacion">
                  <i class="fas fa-sticky-note"></i> <?php echo $pedido->pedido_observacion; ?>
                </div>
              <?php } ?>
            </div>
            <div class="card-footer">
              <button class="btn btn-revertir" onclick="revertirPreparacion(<?php echo $pedido->pedido_id; ?>)">
                <i class="fas fa-arrow-left"></i> VOLVER
              </button>
              <button class="btn btn-preparado" onclick="marcarPreparado(<?php echo $pedido->pedido_id; ?>)">
                <i class="fas fa-check"></i> MARCAR COMO PREPARADO
              </button>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <!-- Columna 3: PREPARADO -->
    <div class="col-md-3">
      <h3 class="column-header preparados">PREPARADO</h3>
      <div id="preparados-column">
        <?php foreach ($this->pedidos_preparados as $pedido) { ?>
          <div class="card">
            <div class="card-header preparados">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <h5 class="card-title">Pedido <span>#<?php echo $pedido->pedido_id; ?></span></h5>
                <small class="card-time"><?php echo date('H:i', strtotime($pedido->pedido_fecha)); ?></small>
              </div>
              <div style="margin-top: 8px;">
                <span class="badge preparados">Preparado</span>
                <!-- <span
                  class="tipo-badge"><?php echo ($pedido->pedido_lugar == 'Kiosko') ? 'Kiosko' : (($pedido->pedido_lugar == 'Mesa') ? 'Mesa' : 'Delivery'); ?></span> -->
              </div>
            </div>
            <div class="card-body">
              <div class="cliente-info">
                <h6><i class="fas fa-user"></i> Cliente</h6>
                <p><strong><?php echo $pedido->pedido_nombre; ?></strong></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $pedido->pedido_lugar; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $pedido->pedido_celular; ?></p>
              </div>
              <h6 class="productos-text">Productos</h6>
              <ul class="productos-list">
                <?php foreach ($pedido->productos as $producto) { ?>
                  <li>
                    <span class="producto-cantidad"><?php echo $producto->pedido_producto_cantidad; ?>x</span>
                    <span class="producto-nombre"><?php echo $producto->pedido_producto_nombre; ?></span>
                  </li>
                <?php } ?>
              </ul>
              <?php if ($pedido->pedido_observacion) { ?>
                <div class="observacion">
                  <i class="fas fa-sticky-note"></i> <?php echo $pedido->pedido_observacion; ?>
                </div>
              <?php } ?>
            </div>
            <div class="card-footer">
              <button class="btn btn-revertir" onclick="revertirPreparado(<?php echo $pedido->pedido_id; ?>)">
                <i class="fas fa-arrow-left"></i> VOLVER
              </button>
              <button class="btn btn-entregado" onclick="marcarEntregado(<?php echo $pedido->pedido_id; ?>)">
                <i class="fas fa-truck"></i> ENTREGADO
              </button>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <!-- Columna 4: ENTREGADO -->
    <div class="col-md-3">
      <h3 class="column-header entregados">ENTREGADO</h3>
      <div id="entregados-column">
        <?php foreach ($this->pedidos_entregados as $pedido) { ?>
          <div class="card">
            <div class="card-header entregados">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <h5 class="card-title">Pedido <span>#<?php echo $pedido->pedido_id; ?></span></h5>
                <small class="card-time"><?php echo date('H:i', strtotime($pedido->pedido_fecha)); ?></small>
              </div>
              <div style="margin-top: 8px;">
                <span class="badge entregados">Entregado</span>
                <!-- <span
                  class="tipo-badge"><?php echo ($pedido->pedido_lugar == 'Kiosko') ? 'Kiosko' : (($pedido->pedido_lugar == 'Mesa') ? 'Mesa' : 'Delivery'); ?></span> -->
              </div>
            </div>
            <div class="card-body">
              <div class="cliente-info">
                <h6><i class="fas fa-user"></i> Cliente</h6>
                <p><strong><?php echo $pedido->pedido_nombre; ?></strong></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $pedido->pedido_lugar; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $pedido->pedido_celular; ?></p>
              </div>
              <h6 class="productos-text">Productos</h6>
              <ul class="productos-list">
                <?php foreach ($pedido->productos as $producto) { ?>
                  <li>
                    <span class="producto-cantidad"><?php echo $producto->pedido_producto_cantidad; ?>x</span>
                    <span class="producto-nombre"><?php echo $producto->pedido_producto_nombre; ?></span>
                  </li>
                <?php } ?>
              </ul>
              <?php if ($pedido->pedido_observacion) { ?>
                <div class="observacion">
                  <i class="fas fa-sticky-note"></i> <?php echo $pedido->pedido_observacion; ?>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script>
  function marcarPreparado (id) {
    window.location.href = '<?php echo $this->route; ?>/marcarPreparado?id=' + id;
  }

  function iniciarPreparacion (id) {
    window.location.href = '<?php echo $this->route; ?>/iniciarPreparacion?id=' + id;
  }

  function marcarEntregado (id) {
    window.location.href = '<?php echo $this->route; ?>/marcarEntregado?id=' + id;
  }
  function revertirPreparacion (id) {
    window.location.href = '<?php echo $this->route; ?>/revertirPreparacion?id=' + id;
  }

  function revertirPreparado (id) {
    window.location.href = '<?php echo $this->route; ?>/revertirPreparado?id=' + id;
  }

  function revertirEntregado (id) {
    window.location.href = '<?php echo $this->route; ?>/revertirEntregado?id=' + id;
  }
  // Actualización automática cada 15 segundos
  setInterval(function () {
    // location.reload();
  }, 15000);

  // Función para reproducir sonido (opcional, si hay archivos de sonido)
  // function playSound(soundFile) {
  //   var audio = new Audio(soundFile);
  //   audio.play();
  // }

  // Ejemplo: playSound('/sounds/new-order.mp3'); al cargar si hay nuevos
</script>