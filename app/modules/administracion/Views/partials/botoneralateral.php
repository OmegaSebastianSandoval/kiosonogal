<ul>
  <?php if (Session::getInstance()->get('kt_login_level') == '1') { ?>
    <li <?php if ($this->botonpanel == 1) { ?>class="activo" <?php } ?>>
      <a href="/administracion/panel">
        <i class="fas fa-info-circle"></i>
        Información Página
      </a>
    </li>
  <?php } ?>
  <li <?php if ($this->botonpanel == 2) { ?>class="activo" <?php } ?>>
    <a href="/administracion/publicidad">
      <i class="far fa-images"></i>
      Administrar Publicidad
    </a>
  </li>
  <li <?php if ($this->botonpanel == 3) { ?>class="activo" <?php } ?>>
    <a href="/administracion/contenido">
      <i class="fas fa-edit"></i>
      Administrar Contenidos
    </a>
  </li>
  <li <?php if ($this->botonpanel == 5) { ?>class="activo" <?php } ?>>
    <a href="/administracion/categorias">
      <i class="fas fa-tags"></i>
      Administrar Categorias
    </a>
  </li>
  <li <?php if ($this->botonpanel == 6) { ?>class="activo" <?php } ?>>
    <a href="/administracion/productos">
      <i class="fas fa-box"></i>
      Administrar Productos
    </a>
  </li>
  <li <?php if ($this->botonpanel == 7) { ?>class="activo" <?php } ?>>
    <a href="/administracion/impuestos">
      <i class="fas fa-calculator"></i>
      Administrar Impuestos
    </a>
  </li>
  <?php if (Session::getInstance()->get('kt_login_level') == '1') { ?>
    <li <?php if ($this->botonpanel == 4) { ?>class="activo" <?php } ?>>
      <a href="/administracion/usuario">
        <i class="fas fa-users"></i>
        Administrar Usuarios
      </a>
    </li>
  <?php } ?>
</ul>