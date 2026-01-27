<?php

/**
 * Controlador para la página de resumen después del pago
 */

class Page_resumenController extends Page_mainController
{
  public function indexAction()
  {
    if(!Session::getInstance()->get('socio')){
      header("Location: /?error=no_auth");
      exit;
    }
    $pedidoId = $_GET['pedido'] ?? null;
    if (!$pedidoId) {
      // Redirigir o mostrar error si no hay pedido
      header("Location: /page/productos?error=no_pedido");
      exit;
    }

    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $pedido = $pedidosModel->getById($pedidoId);
    if (!$pedido) {
      header("Location: /page/productos?error=pedido_no_encontrado");
      exit;
    }
    $socioActual = Session::getInstance()->get('socio');
    if ($pedido->pedido_documento != $socioActual->SBE_CODI) {
      header("Location: /page/productos?error=acceso_denegado");
      exit;
    }
    $pedidosProductosModel = new Administracion_Model_DbTable_Pedidoproductos();
    $productos = $pedidosProductosModel->getList("pedido_producto_pedido = {$pedidoId}");


    $this->_view->pedido = $pedido;
    $this->_view->productos = $productos;

    // Determinar método de pago basado en estado
    $metodoPago = '';
    if ($pedido->pedido_estado == 2) {
      $metodoPago = 'Cargo a la acción';
    } elseif ($pedido->pedido_estado == 3) {
      $metodoPago = 'Datáfono';
    }

    $this->_view->metodoPago = $metodoPago;
  }
}