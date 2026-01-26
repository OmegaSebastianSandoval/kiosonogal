<?php

/**
 * Controlador de productos sencillo
 */

class Page_productosController extends Page_mainController
{

  public function indexAction()
  {

    $socio = Session::getInstance()->get('socio');
    $this->_view->socio = $socio;
    $productosModel = new Administracion_Model_DbTable_Productos();
    $impuestosModel = new Administracion_Model_DbTable_Impuestos();
    $impuestos = $impuestosModel->getList('impuesto_estado = 1', 'impuesto_nombre ASC');

    $porcentajeImpuesto = 0;
    if (is_countable($impuestos) && count($impuestos) > 0) {
      foreach ($impuestos as $impuesto) {
        $porcentajeImpuesto += $impuesto->impuesto_porcentaje;
      }
    }



    $productos = $productosModel->getList('producto_estado = 1', 'producto_nombre ASC');

    $categoriaId = $this->_getSanitizedParam('categoria');
    $subCategoriaId = $this->_getSanitizedParam('subcategoria');
    if ($categoriaId) {

      $productos = $productosModel->getList("producto_estado = 1 AND producto_categoria = '{$categoriaId}' ", 'producto_nombre ASC');

      $this->_view->selectedCategoryId = (int) $categoriaId;
    }
    if ($subCategoriaId) {
      $productos = $productosModel->getList("producto_estado = 1 AND producto_subcategoria = '{$subCategoriaId}' ", 'producto_nombre ASC');
      $this->_view->selectedCategoryId = (int) $categoriaId;
    }


    $productosNormales = [];
    $productosDestacados = [];
    foreach ($productos as $producto) {
      if (
        empty($producto->producto_imagen) ||
        !file_exists(PUBLIC_PATH . '/images/' . $producto->producto_imagen)
      ) {
        $producto->producto_imagen = 'product.gif';
      }

      $producto->producto_precio = $producto->producto_precio + ($producto->producto_precio * ($porcentajeImpuesto / 100));

      if ((int) $producto->producto_destacado === 1) {
        $productosDestacados[] = $producto;
      } else {
        $productosNormales[] = $producto;
      }
    }

    $this->_view->productosNormales = $productosNormales;
    $this->_view->productosDestacados = $productosDestacados;
    $this->_view->securityHash = md5('totem_secret_omega' . date('Y-m-d'));


    $publicidadController = new Administracion_Model_DbTable_Publicidad();
    $popUpHome = $publicidadController->getList("publicidad_seccion='102' AND publicidad_estado='1'", "orden ASC")[0];

    $this->_view->popup = $popUpHome;
  }
}
