<?php

class Administracion_listpedidosController extends Administracion_mainController
{
  public function indexAction()
  {
    $title = "Pedidos Listos para Preparación";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;
    $this->_view->route = "/administracion/listpedidos";
    $pedidosModel = new Administracion_Model_DbTable_Pedidos();
    $pedidoProductosModel = new Administracion_Model_DbTable_Pedidoproductos();
    $pedidos = $pedidosModel->getList("pedido_estado_preparacion = 1", 'pedido_fecha ASC');
    foreach ($pedidos as $pedido) {
      $pedido->productos = $pedidoProductosModel->getList("pedido_producto_pedido = {$pedido->pedido_id}");
    }

    $this->_view->pedidos = $pedidos;

  }

  public function prepararAction()
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
}
