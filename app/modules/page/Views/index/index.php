<div class="home-page">
  <span></span>
  <a class="totem-btn totem-btn-primary btn-large" href="/page/productos">
    Ingresar
  </a>
</div>
<style>
  .btn-large {
    max-width: 400px;
  }

  header {
    display: none;
  }

  <?php

  if (
    $this->fondoHome->publicidad_imagen &&
    file_exists(PUBLIC_PATH . '/images/' . $this->fondoHome->publicidad_imagen)
  ): ?>
    .home-page {
      background-image: url(/images/<?= $this->fondoHome->publicidad_imagen; ?>);
    }

  <?php endif; ?>
</style>