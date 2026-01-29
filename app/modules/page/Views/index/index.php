<div class="home-page">
  <span></span>
  <a class="totem-btn totem-btn-primary btn-large" href="/page/productos">
    Ingresar
  </a>
  <?php if ($this->popup->publicidad_estado == 1) { ?>
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
  <?php if ($this->popup->publicidad_estado == 1) { ?>
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

  <?php else: ?>
    .home-page {
      background-image: url(/skins/page/images/home.jpg);
    }
  <?php endif; ?>
</style>