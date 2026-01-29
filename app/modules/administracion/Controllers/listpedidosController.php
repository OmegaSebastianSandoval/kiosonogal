<?php

class Administracion_listpedidosController extends Administracion_mainController
{
  public function indexAction()
  {
    $title = "Kitchen Display System";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;
    $this->_view->route = "/administracion/listpedidos";
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $pedidoProductosModel = new Administracion_Model_DbTable_Pedidoproductos();
    $hoy = date('Y-m-d');
    $fecha_inicio = $hoy . " 00:00:00";
    $fecha_fin = $hoy . " 23:59:59";
    $pedidos = $pedidosModel->getList("pedido_estado_preparacion < 5 AND pedido_fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'", 'pedido_fecha ASC');
    foreach ($pedidos as $pedido) {
      $pedido->productos = $pedidoProductosModel->getList("pedido_producto_pedido = {$pedido->pedido_id}");
    }

    // Agrupar pedidos por estado
    $pedidos_listos = [];
    $pedidos_preparando = [];
    $pedidos_preparados = [];
    $pedidos_entregados = [];

    foreach ($pedidos as $pedido) {
      switch ($pedido->pedido_estado_preparacion) {
        case 1:
          $pedidos_listos[] = $pedido;
          break;
        case 2:
          $pedidos_preparando[] = $pedido;
          break;
        case 3:
          $pedidos_preparados[] = $pedido;
          break;
        case 4:
          $pedidos_entregados[] = $pedido;
          break;
      }
    }

    // Limitar entregados a los últimos 10
    $pedidos_entregados = array_slice(array_reverse($pedidos_entregados), 0, 10);

    $this->_view->pedidos_listos = $pedidos_listos;
    $this->_view->pedidos_preparando = $pedidos_preparando;
    $this->_view->pedidos_preparados = $pedidos_preparados;
    $this->_view->pedidos_entregados = $pedidos_entregados;

  }

  public function marcarPreparadoAction()
  {
    $id = $this->_getSanitizedParam('id');
    if ($id) {
      $pedidosModel = new Administracion_Model_DbTable_Pedidos();

      $pedidosModel->editField($id, "pedido_estado_preparacion", 3);
      header('Location: /administracion/listpedidos');
      exit;
    } else {
      header('Location: /administracion/listpedidos');
      exit;
    }
  }

  public function iniciarPreparacionAction()
  {
    $id = $this->_getSanitizedParam('id');
    if ($id) {
      $pedidosModel = new Administracion_Model_DbTable_Pedidos();

      $pedidosModel->editField($id, "pedido_estado_preparacion", 2);
      header('Location: /administracion/listpedidos');
      exit;
    } else {
      header('Location: /administracion/listpedidos');
      exit;
    }
  }

  public function marcarEntregadoAction()
  {
    $id = $this->_getSanitizedParam('id');
    if ($id) {
      $pedidosModel = new Administracion_Model_DbTable_Pedidos();

      $pedidosModel->editField($id, "pedido_estado_preparacion", 4);
      header('Location: /administracion/listpedidos');
      exit;
    } else {
      header('Location: /administracion/listpedidos');
      exit;
    }
  }

  public function revertirPreparacionAction()
  {
    $id = $this->_getSanitizedParam('id');
    if ($id) {
      $pedidosModel = new Administracion_Model_DbTable_Pedidos();

      $pedidosModel->editField($id, "pedido_estado_preparacion", 1);
      header('Location: /administracion/listpedidos');
      exit;
    } else {
      header('Location: /administracion/listpedidos');
      exit;
    }
  }

  public function revertirPreparadoAction()
  {
    $id = $this->_getSanitizedParam('id');
    if ($id) {
      $pedidosModel = new Administracion_Model_DbTable_Pedidos();

      $pedidosModel->editField($id, "pedido_estado_preparacion", 2);
      header('Location: /administracion/listpedidos');
      exit;
    } else {
      header('Location: /administracion/listpedidos');
      exit;
    }
  }

  public function revertirEntregadoAction()
  {
    $id = $this->_getSanitizedParam('id');
    if ($id) {
      $pedidosModel = new Administracion_Model_DbTable_Pedidos();

      $pedidosModel->editField($id, "pedido_estado_preparacion", 3);
      header('Location: /administracion/listpedidos');
      exit;
    } else {
      header('Location: /administracion/listpedidos');
      exit;
    }
  }
}
