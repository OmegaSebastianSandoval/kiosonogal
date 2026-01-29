<?php

/**
 * Controlador de productos sencillo
 */

class Page_productosController extends Page_mainController
{

  public function indexAction()
  {

    $categoriasModel = new Administracion_Model_DbTable_Categorias();
    $categorias = $categoriasModel->getList('categoria_estado = 1', 'orden ASC');

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
    // $impuestosModel = new Administracion_Model_DbTable_Impuestos();
    // $impuestos = $impuestosModel->getList('impuesto_estado = 1', 'impuesto_nombre ASC');

    // $porcentajeImpuesto = 0;
    // if (is_countable($impuestos) && count($impuestos) > 0) {
    //   foreach ($impuestos as $impuesto) {
    //     $porcentajeImpuesto += $impuesto->impuesto_porcentaje;
    //   }
    // }



    $productos = $productosModel->getList('producto_estado = 1 AND producto_cantidad > 0', 'producto_destacado DESC, producto_nuevo DESC, producto_nombre ASC');

    $categoriaId = $this->_getSanitizedParam('categoria');
    $subCategoriaId = $this->_getSanitizedParam('subcategoria');
    $ordenParam = $this->_getSanitizedParam('orden') ?: 'destacado';

    // Definir orden basado en parámetro
    switch ($ordenParam) {
      case 'nombre_asc':
        $orden = 'producto_nombre ASC';
        break;
      case 'nombre_desc':
        $orden = 'producto_nombre DESC';
        break;
      case 'precio_asc':
        $orden = 'CAST(producto_precio AS DECIMAL(10,2)) ASC';
        break;
      case 'precio_desc':
        $orden = 'CAST(producto_precio AS DECIMAL(10,2)) DESC';
        break;
      case 'destacado':
      default:
        $orden = 'producto_destacado DESC, producto_nuevo DESC, producto_nombre ASC';
        break;
    }

    $categoriaInfo = $categoriasModel->getById($categoriaId);
    if ($categoriaInfo) {
      $productos = $productosModel->getList("producto_estado = 1 AND producto_categoria = '{$categoriaId}' AND producto_cantidad > 0", $orden);
      $this->_view->selectedCategoryId = (int) $categoriaId;
      $this->_view->categoriaInfo = $categoriaInfo;
    }
    if ($subCategoriaId) {
      $productos = $productosModel->getList("producto_estado = 1 AND producto_subcategoria = '{$subCategoriaId}' AND producto_cantidad > 0", $orden);
      $this->_view->selectedCategoryId = (int) $categoriaId;
    }

    // Si no hay categoria ni subcategoria, aplicar orden a todos
    if (!$categoriaId && !$subCategoriaId) {
      $productos = $productosModel->getList('producto_estado = 1 AND producto_cantidad > 0', $orden);
    }

    $this->_view->selectedOrden = $ordenParam;


    foreach ($productos as $producto) {
      if (
        empty($producto->producto_imagen) ||
        !file_exists(PUBLIC_PATH . '/images/' . $producto->producto_imagen)
      ) {
        $producto->producto_imagen = 'product.gif';
      }

      // $producto->producto_precio = $producto->producto_precio + ($producto->producto_precio * ($porcentajeImpuesto / 100));


    }

    $this->_view->productos = $productos;
    $this->_view->carrito = $this->getCarrito();
    $this->_view->securityHash = md5('totem_secret_omega' . date('Y-m-d'));

    // Obtener productos del carrito para thumbnails
    $carrito = $this->getCarrito();
    $carritoProductos = [];
    foreach ($carrito as $id => $cantidad) {
      $productoInfo = $productosModel->getById($id);
      if ($productoInfo) {
        if (empty($productoInfo->producto_imagen) || !file_exists(PUBLIC_PATH . '/images/' . $productoInfo->producto_imagen)) {
          $productoInfo->producto_imagen = 'product.gif';
        }
        $carritoProductos[] = $productoInfo;
      }
    }
    $this->_view->carritoProductos = $carritoProductos;


    $publicidadController = new Administracion_Model_DbTable_Publicidad();
    $popUpHome = $publicidadController->getList("publicidad_seccion='102' AND publicidad_estado='1'", "orden ASC")[0];

    $this->_view->popup = $popUpHome;
  }

  public function getCarrito()
  {
    if (Session::getInstance()->get("carrito")) {
      return Session::getInstance()->get("carrito");
    } else {
      return [];
    }
  }
}
