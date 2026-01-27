<?php

/**
 * Controlador de productos sencillo
 */

class Page_productosController extends Page_mainController
{

  public function indexAction()
  {

    $categoriasModel = new Administracion_Model_DbTable_Categorias();
    $categorias = $categoriasModel->getList('categoria_estado = 1', 'categoria_nombre ASC');

    $categoriasPadre = [];
    $subcategoriasPorPadre = [];

    foreach ($categorias as $categoria) {
      if (
        empty($categoria->categoria_imagen) ||
        !file_exists(PUBLIC_PATH . '/images/' . $categoria->categoria_imagen)
      ) {
        $categoria->categoria_imagen = 'default_category.jpg';
      }
      if ((int) $categoria->categoria_padre === 0) {
        $categoria->subcategorias = []; // importante
        $categoriasPadre[$categoria->categoria_id] = $categoria;
      } else {
        $subcategoriasPorPadre[$categoria->categoria_padre][] = $categoria;
      }
    }
    foreach ($categoriasPadre as $idPadre => $categoriaPadre) {
      if (isset($subcategoriasPorPadre[$idPadre])) {
        $categoriaPadre->subcategorias = $subcategoriasPorPadre[$idPadre];
      }
    }


    $this->_view->categoriasList = array_values($categoriasPadre);



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

      $productos = $productosModel->getList("producto_estado = 1 AND producto_categoria = '{$categoriaId}' ", 'producto_nuevo DESC, producto_nombre ASC');

      $this->_view->selectedCategoryId = (int) $categoriaId;
    }
    if ($subCategoriaId) {
      $productos = $productosModel->getList("producto_estado = 1 AND producto_subcategoria = '{$subCategoriaId}' ", 'producto_nuevo DESC, producto_nombre ASC');
      $this->_view->selectedCategoryId = (int) $categoriaId;
    }


    $productosNormales = [];
    $productosDestacados = [];
    $productosTodos = [];
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
