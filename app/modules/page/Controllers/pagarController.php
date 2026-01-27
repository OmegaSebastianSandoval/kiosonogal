<?php

class Page_pagarController extends Page_mainController
{
  public function indexAction()
  {
    // Procesar datos del formulario si es POST
    if (!$_SERVER['REQUEST_METHOD'] === 'POST')
      return;

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";


    // Página de resumen después del pago
  }
  public function cargoAction()
  {
    $this->setLayout('blanco');
    // Procesar datos del formulario si es POST
    if (!$_SERVER['REQUEST_METHOD'] === 'POST')
      return;

    $socio = Session::getInstance()->get('socio');
    if (!$socio) {
      header("Location: /page/productos?error=sesion");
      exit;
    }
    if (!$socio->SBE_CUPO || (int) $socio->SBE_CUPO <= 0) {
      header("Location: /page/productos?error=cupo");
      exit;
    }
    $carrito = Session::getInstance()->get("carrito");
    if (empty($carrito) || !is_countable($carrito) || count($carrito) === 0) {
      header("Location: /page/productos?error=carrito_vacio");
      exit;
    }
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $pedidosProductosModel = new Administracion_Model_DbTable_Pedidoproductos();
    $productoModel = new Administracion_Model_DbTable_Productos();
    $impuestosModel = new Administracion_Model_DbTable_Impuestos();
    $impuestos = $impuestosModel->getList('impuesto_estado = 1', 'impuesto_nombre ASC');

    $porcentajeImpuesto = 0;
    if (is_countable($impuestos) && count($impuestos) > 0) {
      foreach ($impuestos as $impuesto) {
        $porcentajeImpuesto += $impuesto->impuesto_porcentaje;
      }
    }
    $productosCarrito = [];
    $totalSinImpuestos = 0;
    $totalConImpuestos = 0;
    foreach ($carrito as $id => $cantidad) {
      $productoInfo = $productoModel->getById($id);
      // Si el producto ya no existe en BD, lo saltamos (evita errores fatales)
      if (!$productoInfo) {
        continue;
      }
      if (empty($productoInfo->producto_imagen) || !file_exists(PUBLIC_PATH . '/images/' . $productoInfo->producto_imagen)) {
        $productoInfo->producto_imagen = 'product.gif';
      }

      $productoInfo->producto_precio_total = $productoInfo->producto_precio + $productoInfo->producto_precio * ($porcentajeImpuesto / 100);

      $totalSinImpuestos += $productoInfo->producto_precio * (int) $cantidad;
      $totalConImpuestos += $productoInfo->producto_precio_total * (int) $cantidad;

      $productosCarrito[$id] = [];
      $productosCarrito[$id]['detalle'] = $productoInfo;
      $productosCarrito[$id]['cantidad'] = (int) $cantidad;
    }

    $data = $this->getDataCompraCargo();
    $data['pedido_valorpagar'] = $totalConImpuestos;
    $pedidoId = $pedidosModel->insert($data);
    if (!$pedidoId) {
      header("Location: /page/productos?error=pedido");
      exit;
    }
    foreach ($productosCarrito as $id => $productoCarrito) {
      $dataProducto = [];
      $dataProducto['pedido_producto_pedido'] = $pedidoId;
      $dataProducto['pedido_producto_producto'] = $productoCarrito['detalle']->producto_id;
      $dataProducto['pedido_producto_nombre'] = $productoCarrito['detalle']->producto_nombre;
      $dataProducto['pedido_producto_imagen'] = $productoCarrito['detalle']->producto_imagen;
      $dataProducto['pedido_producto_cantidad'] = $productoCarrito['cantidad'];
      $dataProducto['pedido_producto_valor'] = $productoCarrito['detalle']->producto_precio;
      $dataProducto['pedido_producto_valor_impuestos'] = $productoCarrito['detalle']->producto_precio * ($porcentajeImpuesto / 100);
      $dataProducto['pedido_producto_valor_total'] = $productoCarrito['detalle']->producto_precio_total * $productoCarrito['cantidad'];
      $dataProducto['pedido_producto_ingredientes'] = '';
      $dataProducto['pedido_producto_ingredientes_ids'] = '';
      $pedidosProductosModel->insert($dataProducto);
    }

    // Limpiar carrito
    Session::getInstance()->set("carrito", []);
    header("Location: /page/resumen?pedido={$pedidoId}");


    // Página de resumen después del pago
  }

  public function getDataCompraCargo()
  {

    $socio = Session::getInstance()->get('socio');
    $carrito = Session::getInstance()->get("carrito");

    $dataCompra = [
      'pedido_documento' => $socio->SBE_CODI,
      'pedido_nombre' => $socio->sbe_nombre . ' ' . $socio->sbe_apel,
      'pedido_correo' => $socio->sbe_mail,
      'pedido_celular' => $socio->sbe_ncel,
      'pedido_propina' => 0,
      'pedido_fecha' => date('Y-m-d H:i:s'),
      'pedido_estado' => 2,
      'pedido_estado_texto' => 'Pago por cargo a la acción',
      'pedido_estado_texto2' => 'El pedido ha sido pagado con cargo a la acción del socio.',
      'pedido_cus' => null,
      'pedido_franquicia' => null,
      'pedido_medio' => 'cargo',
      'pedido_nombrefe' => null,
      'pedido_correofe' => null,
      'pedido_celularfe' => null,
      'pedido_request_id' => null,
      'pedido_ip' => $_SERVER['REMOTE_ADDR'] ?? null,
      'pedido_numeroaccion' => $socio->MAC_NUME,
      'pedido_numerocarnet' => $socio->numero_carnet,
      'pedido_observacion' => $_POST['observacion'] ?? null,
      'pedido_cuotas' => $_POST['cuotas'] ?? null,
      'pedido_lugar' => $_POST['lugar'] ?? null,
      'pedido_estado_preparacion' => 1,
      'pedido_estado_preparacion_text' => 'Pendiente de preparación',
    ];

    return $dataCompra;


  }
}