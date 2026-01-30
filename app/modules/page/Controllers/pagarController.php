<?php

class Page_pagarController extends Page_mainController
{
  public function indexAction()
  {

  }
  public function cargoAction()
  {
    $this->setLayout('blanco');
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

    $iva = $impuestosModel->getById(1);

    $porcentajeImpuesto = 0;
    if (is_countable($impuestos) && count($impuestos) > 0) {
      foreach ($impuestos as $impuesto) {
        $porcentajeImpuesto += $impuesto->impuesto_porcentaje;
      }
    }
    $productosCarrito = [];
    // $totalSinImpuestos = 0;
    $totalCarrito = 0;
    foreach ($carrito as $id => $cantidad) {
      $productoInfo = $productoModel->getById($id);
      if (!$productoInfo) {
        continue;
      }
      if (empty($productoInfo->producto_imagen) || !file_exists(PUBLIC_PATH . '/images/' . $productoInfo->producto_imagen)) {
        $productoInfo->producto_imagen = 'product.gif';
      }

      // $productoInfo->producto_precio_total = $productoInfo->producto_precio + $productoInfo->producto_precio * ($porcentajeImpuesto / 100);


      // $totalSinImpuestos += $productoInfo->producto_precio * (int) $cantidad;
      $totalCarrito += $productoInfo->producto_precio * (int) $cantidad;

      $productosCarrito[$id] = [];
      $productosCarrito[$id]['detalle'] = $productoInfo;
      $productosCarrito[$id]['cantidad'] = (int) $cantidad;
    }

    $data = $this->getDataCompraCargo();
    $data['pedido_valorpagar'] = $totalCarrito;
    $data['pedido_iva'] = $iva->impuesto_porcentaje;
    $data['pedido_impuestos'] = $totalCarrito * ($porcentajeImpuesto / 100);
    $data['pedido_kiosko'] = isset($_COOKIE['kiosk_id']) ? $_COOKIE['kiosk_id'] : 1;
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
      $dataProducto['pedido_producto_valor_total'] = $productoCarrito['detalle']->producto_precio * $productoCarrito['cantidad'];
      $dataProducto['pedido_producto_ingredientes'] = '';
      $dataProducto['pedido_producto_ingredientes_ids'] = '';
      $pedidosProductosModel->insert($dataProducto);
    }

    $this->descontarProductosInventario($productosCarrito);

    Session::getInstance()->set("carrito", []);
    header("Location: /page/resumen?pedido={$pedidoId}");


  }
  public function datafonoAction()
  {
    $this->setLayout('blanco');
    if (!$_SERVER['REQUEST_METHOD'] === 'POST')
      return;

    $socio = Session::getInstance()->get('socio');
    if (!$socio) {
      header("Location: /page/productos?error=sesion");
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
    $iva = $impuestosModel->getById(1);

    $porcentajeImpuesto = 0;
    if (is_countable($impuestos) && count($impuestos) > 0) {
      foreach ($impuestos as $impuesto) {
        $porcentajeImpuesto += $impuesto->impuesto_porcentaje;
      }
    }
    $productosCarrito = [];
    // $totalSinImpuestos = 0;
    $totalCarrito = 0;
    foreach ($carrito as $id => $cantidad) {
      $productoInfo = $productoModel->getById($id);
      if (!$productoInfo) {
        continue;
      }
      if (empty($productoInfo->producto_imagen) || !file_exists(PUBLIC_PATH . '/images/' . $productoInfo->producto_imagen)) {
        $productoInfo->producto_imagen = 'product.gif';
      }

      // $productoInfo->producto_precio_total = $productoInfo->producto_precio + $productoInfo->producto_precio * ($porcentajeImpuesto / 100);


      // $totalSinImpuestos += $productoInfo->producto_precio * (int) $cantidad;
      $totalCarrito += $productoInfo->producto_precio * (int) $cantidad;

      $productosCarrito[$id] = [];
      $productosCarrito[$id]['detalle'] = $productoInfo;
      $productosCarrito[$id]['cantidad'] = (int) $cantidad;
    }

    $data = $this->getDataCompraDatafono();
    $data['pedido_valorpagar'] = $totalCarrito;
    $data['pedido_iva'] = $iva->impuesto_porcentaje;
    $data['pedido_impuestos'] = $totalCarrito * ($porcentajeImpuesto / 100);
    $data['pedido_kiosko'] = isset($_COOKIE['kiosk_id']) ? $_COOKIE['kiosk_id'] : 1;
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
      $dataProducto['pedido_producto_valor_total'] = $productoCarrito['detalle']->producto_precio * $productoCarrito['cantidad'];
      $dataProducto['pedido_producto_ingredientes'] = '';
      $dataProducto['pedido_producto_ingredientes_ids'] = '';
      $pedidosProductosModel->insert($dataProducto);
    }

    header("Location: /page/pagar/esperadatafono?pedido={$pedidoId}");
  }

  public function esperadatafonoAction()
  {

    $pedidoId = $this->_getSanitizedParam('pedido');
    if (!$pedidoId) {
      header("Location: /page/productos?error=pedido");
      exit;
    }
    $pedidoModel = new Administracion_Model_DbTable_Pedidos();
    $pedido = $pedidoModel->getById($pedidoId);
    if (!$pedido) {
      header("Location: /page/productos?error=pedido");
      exit;
    }

    $kioskoID = isset($_COOKIE['kiosk_id']) ? $_COOKIE['kiosk_id'] : 1;
    $kioskoModel = new Administracion_Model_DbTable_Kioskos();
    $kiosko = $kioskoModel->getById($kioskoID);
    if (!$kiosko) {
      header("Location: /page/productos?error=kiosko");
      exit;
    }

    $this->_view->pedidoId = $pedidoId;
  }

  public function procesardatafonoAction()
  {
    $this->setLayout('blanco');
    $pedidoId = $this->_getSanitizedParam('pedido');
    if (!$pedidoId) {
      echo json_encode([
        'estado' => 'ERROR',
        'msg' => 'Pedido no válido'
      ]);
      exit;
    }
    $pedidoModel = new Administracion_Model_DbTable_Pedidos();
    $pedido = $pedidoModel->getById($pedidoId);
    if (!$pedido) {
      echo json_encode([
        'estado' => 'ERROR',
        'msg' => 'Pedido no encontrado'
      ]);
      exit;
    }

    $kioskoID = isset($_COOKIE['kiosk_id']) ? $_COOKIE['kiosk_id'] : 1;
    $kioskoModel = new Administracion_Model_DbTable_Kioskos();
    $kiosko = $kioskoModel->getById($kioskoID);
    if (!$kiosko) {
      echo json_encode([
        'estado' => 'ERROR',
        'msg' => 'Kiosko no encontrado'
      ]);
      exit;
    }
    $iva = $pedido->pedido_iva;
    $total = $pedido->pedido_valorpagar;
    $iva = intval(round($iva));
    $total = intval(round($total));

    if ($total <= 0) {
      echo json_encode([
        'estado' => 'ERROR',
        'msg' => 'Total inválido'
      ]);
      exit;
    }
    $recibo = substr($pedidoId, -6); // últimos 6 dígitos
    $transaccion = $pedidoId;        // el ID completo

    $tefData = [
      'amount' => $total,
      'terminalId' => $kioskoID,
      'cashierId' => $kioskoID,
      'transactionId' => $transaccion,    // ID transacción
    ];
    $payload = json_encode($tefData);

    $ch = curl_init('http://localhost:3000/api/purchase');
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_TIMEOUT => 120, // el POS puede tardar
    ]);
    $response = curl_exec($ch);

    if ($response === false) {
      echo json_encode([
        'estado' => 'ERROR',
        'msg' => 'No se pudo comunicar con el servicio TEF'
      ]);
      exit;
    }

    curl_close($ch);
    $resultado = json_decode($response, true);
    /*
    {
      "status": "ok",
      "message": "Transacción aprobada",
      "data": {
        "success": true,
        "authCode": "MOCK662734",
        "responseCode": "00",
        "amount": "000000100000",
        "transactionId": "MAC_TEST",
        "terminalId": "MAC01",
        "cashierId": "MAC_USER",
        "franchise": "VISA",
        "accountType": "CR",
        "last4": "1234",
        "maskedPan": "400558******1234",
        "receiptNumber": "617977"
      }
    }
    */
    if (isset($resultado['status']) && ($resultado['status'] === 'approved' || $resultado['status'] === 'ok')) {

      $dataResultado = $resultado['data'] ?? [];
      // Actualizar pedido como pagado
      $pedidoModel->actualizarEstadoPedido(
        $pedidoId,
        2, // estado pagado
        'Pago aprobado por datáfono',
        'El pago fue aprobado exitosamente',
        1, // estado preparación pendiente
        print_r($resultado, true)
      );

      // Descontar inventario
      $this->descontarProductosInventario($pedidoId);

      echo json_encode([
        'estado' => 'OK',
        'msg' => 'Pago exitoso',
        'status' => 'approved'
      ]);
      return;
    } else {
      // Pago rechazado
      $pedidoModel->actualizarEstadoPedido(
        $pedidoId,
        3, // estado rechazado
        'Pago rechazado',
        'El pago fue rechazado por el banco',
        9,
        print_r($resultado, true)
      );

      echo json_encode([
        'estado' => 'ERROR',
        'msg' => $resultado['msg'] ?? 'Pago rechazado',
        'status' => 'rejected'
      ]);
      return;
    }
    // echo json_encode($resultado);

  }
  function pad($value, $length)
  {
    return str_pad($value, $length, '0', STR_PAD_LEFT);
  }
  public function getDataCompraCargo()
  {
    $socio = Session::getInstance()->get('socio');
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
  public function getDataCompraDatafono()
  {
    $socio = Session::getInstance()->get('socio');
    $dataCompra = [
      'pedido_documento' => $socio->SBE_CODI,
      'pedido_nombre' => $socio->sbe_nombre . ' ' . $socio->sbe_apel,
      'pedido_correo' => $socio->sbe_mail,
      'pedido_celular' => $socio->sbe_ncel,
      'pedido_propina' => 0,
      'pedido_fecha' => date('Y-m-d H:i:s'),
      'pedido_estado' => 1,
      'pedido_estado_texto' => 'Iniciado pago por datáfono',
      'pedido_estado_texto2' => 'El pedido está en proceso de pago por datáfono.',
      'pedido_cus' => null,
      'pedido_franquicia' => null,
      'pedido_medio' => 'datafono',
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
      'pedido_estado_preparacion' => null,
      'pedido_estado_preparacion_text' => null
    ];
    return $dataCompra;
  }

  public function descontarProductosInventario($productosCarrito)
  {
    $productoModel = new Administracion_Model_DbTable_Productos();
    foreach ($productosCarrito as $id => $productoCarrito) {
      $productoInfo = $productoModel->getById($id);
      if ($productoInfo) {
        $nuevaCantidad = $productoInfo->producto_cantidad - (int) $productoCarrito['cantidad'];
        if ($nuevaCantidad < 0) {
          $nuevaCantidad = 0;
        }
        $productoModel->editField($id, 'producto_cantidad', $nuevaCantidad);
      }
    }
  }

}