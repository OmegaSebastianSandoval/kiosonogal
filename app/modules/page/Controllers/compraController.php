<?php

/**
 * Controlador para proceso de compra / pago (simulación kiosco)
 */

class Page_compraController extends Page_mainController
{
  public function indexAction()
  {

    $productoModel = new Administracion_Model_DbTable_Productos();
    $impuestosModel = new Administracion_Model_DbTable_Impuestos();
    $impuestos = $impuestosModel->getList('impuesto_estado = 1', 'impuesto_nombre ASC');

    $porcentajeImpuesto = 0;
    if (is_countable($impuestos) && count($impuestos) > 0) {
      foreach ($impuestos as $impuesto) {
        $porcentajeImpuesto += $impuesto->impuesto_porcentaje;
      }
    }
    $carrito = $this->getCarrito();

    $data = [];
    $valortotal = 0;

    foreach ($carrito as $id => $cantidad) {
      $productoInfo = $productoModel->getById($id);
      // Si el producto ya no existe en BD, lo saltamos (evita errores fatales)
      if (!$productoInfo) {
        continue;
      }
      if (empty($productoInfo->producto_imagen) || !file_exists(PUBLIC_PATH . '/images/' . $productoInfo->producto_imagen)) {
        $productoInfo->producto_imagen = 'product.gif';
      }



      $precioUnitario = isset($productoInfo->producto_precio) ? (float) $productoInfo->producto_precio : 0;
      $lineTotal = $precioUnitario * (int) $cantidad;
      $valortotal += $lineTotal;

      $data[$id] = [];
      $data[$id]['detalle'] = $productoInfo;
      $data[$id]['cantidad'] = (int) $cantidad;
      $data[$id]['lineTotal'] = $lineTotal;
    }

    $this->_view->carrito = $data;
    $this->_view->valortotal = $valortotal;
  }

  public function getCarrito()
  {
    if (Session::getInstance()->get("carrito")) {
      return Session::getInstance()->get("carrito");
    } else {
      return [];
    }
  }

  public function pagarAction()
  {
    // Endpoint AJAX que simula el pago (tipo kiosco)
    $this->setLayout("blanco");
    header('Content-Type: application/json');

    $metodo = $this->_getSanitizedParam('metodo');
    $monto = $this->_getSanitizedParam('monto');

    $carrito = $this->getCarrito();
    if (empty($carrito)) {
      echo json_encode(['success' => false, 'message' => 'El carrito está vacío']);
      exit;
    }

    // Simular transacción
    $transactionId = uniqid('txn_');

    // Registrar en log (similar a agregar/eliminar)
    $logcarritoModel = new Administracion_Model_DbTable_Logcarrito();
    $socio = Session::getInstance()->get('socio');
    $dataLog['log_cedula'] = $socio ? $socio->SBE_CODI : null;
    $dataLog['log_detalle'] = "Pago simulado (kiosco)";
    $dataLog['log_log'] = print_r([
      'metodo' => $metodo,
      'monto' => $monto,
      'transaction' => $transactionId,
      'carrito' => $carrito
    ], true);
    $dataLog['log_fecha'] = date("Y-m-d H:i:s");
    $logcarritoModel->insert($dataLog);

    // Limpiar carrito
    Session::getInstance()->set("carrito", []);

    echo json_encode([
      'success' => true,
      'message' => 'Pago realizado con éxito',
      'transaction' => $transactionId,
      'metodo' => $metodo,
      'monto' => $monto
    ]);
    exit;
  }
}
