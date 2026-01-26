<?php

/**
 *
 */

class Page_indexController extends Page_mainController
{

  public function indexAction()
  {
    $socio = Session::getInstance()->get('socio');

    if ($socio && $socio->SBE_CODI) {
      header("Location: /page/productos");
      return;
    }

    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");

    $publicidadController = new Administracion_Model_DbTable_Publicidad();
    $popUpHome = $publicidadController->getList("publicidad_seccion='101' AND publicidad_estado='1'", "orden ASC")[0];

    $this->_view->popup = $popUpHome;
    $fondoHome = $publicidadController->getList("publicidad_seccion='1' AND publicidad_estado='1'", "orden ASC")[0];
    $this->_view->fondoHome = $fondoHome;



  }
  public function logoutAction()
  {
    Session::getInstance()->set('socio', null);
    Session::getInstance()->set('carrito', null);
    session_destroy();
    header("Location: /");
    return;
  }
}
