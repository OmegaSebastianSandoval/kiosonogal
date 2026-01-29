<?php

/**
 *
 */

class Page_carritoController extends Page_mainController
{

	public function indexAction()
	{



		$this->setLayout("blanco");
		$productoModel = new Administracion_Model_DbTable_Productos();
		$carrito = $this->getCarrito();
		$impuestosModel = new Administracion_Model_DbTable_Impuestos();

		$impuestos = $impuestosModel->getList('impuesto_estado = 1', 'impuesto_nombre ASC');

		$porcentajeImpuesto = 0;
		if (is_countable($impuestos) && count($impuestos) > 0) {
			foreach ($impuestos as $impuesto) {
				$porcentajeImpuesto += $impuesto->impuesto_porcentaje;
			}
		}

		$data = [];
		foreach ($carrito as $id => $cantidad) {
			$productoInfo = $productoModel->getById($id);
			// saltar si producto eliminado o inválido
			if (!$productoInfo) {
				continue;
			}
			if (empty($productoInfo->producto_imagen) || !file_exists(PUBLIC_PATH . '/images/' . $productoInfo->producto_imagen)) {
				$productoInfo->producto_imagen = 'product.gif';
			}
			$base_precio = $productoInfo->producto_precio;
			// $productoInfo->producto_precio = $productoInfo->producto_precio + ($productoInfo->producto_precio * ($porcentajeImpuesto / 100));


			$data[$id] = [];
			$data[$id]['detalle'] = $productoInfo;
			$data[$id]['cantidad'] = (int) $cantidad;
			$data[$id]['base_precio'] = $base_precio;

		}

		$subtotal = 0;
		foreach ($data as $item) {
			$subtotal += $item['cantidad'] * $item['base_precio'];
		}
		$taxes = $subtotal * ($porcentajeImpuesto / 100);
		$total = $subtotal;

		$subtotal = $subtotal - $taxes;

		$this->_view->carrito = $data;
		$this->_view->subtotal = $subtotal;
		$this->_view->impuestos = $taxes;
		$this->_view->total = $total;
	}

	public function getCarrito()
	{
		if (Session::getInstance()->get("carrito")) {
			return Session::getInstance()->get("carrito");
		} else {
			return [];
		}
	}

	public function additemAction()
	{
		if (!Session::getInstance()->get("socio"))
			return;
		$this->setLayout("blanco");
		header('Content-Type: application/json');
		$id = $this->_getSanitizedParam("producto");
		$cantidad = $this->_getSanitizedParam("cantidad");
		$productoModel = new Administracion_Model_DbTable_Productos();
		$productoInfo = $productoModel->getById($id);
		if (!$productoInfo) {
			echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
			return;
		}
		$limite = $productoInfo->producto_limite_pedido ?? 0;
		$carrito = $this->getCarrito();
		$nuevaCantidad = ($carrito[$id] ?? 0) + $cantidad;
		if ($limite > 0 && $nuevaCantidad > $limite) {
			echo json_encode(['success' => false, 'message' => 'No se puede agregar más de ' . $limite . ' unidades de este producto.']);
			return;
		}
		if ($carrito[$id]) {
			$carrito[$id] = $carrito[$id] + $cantidad;
		} else {
			$carrito[$id] = $cantidad;
		}

		Session::getInstance()->set("carrito", $carrito);
		//log carrito
		$array['id'] = $id;
		$array['cantidad'] = $cantidad;
		$array['carrito'] = $carrito;
		$logcarritoModel = new Administracion_Model_DbTable_Logcarrito();
		$socio = Session::getInstance()->get('socio');
		$data['log_cedula'] = $socio ? $socio->SBE_CODI : null;
		$data['log_detalle'] = "Agregar al carrito";
		$data['log_log'] = print_r($array, true);
		$data['log_fecha'] = date("Y-m-d H:i:s");
		$logcarritoModel->insert($data);
		echo json_encode(['success' => true]);

	}

	public function deleteitemAction()
	{


		$this->setLayout("blanco");
		$id = $this->_getSanitizedParam("producto");
		$carrito = $this->getCarrito();


		if ($carrito[$id]) {
			unset($carrito[$id]);
		}
		Session::getInstance()->set("carrito", $carrito);

		//log carrito
		$array['id'] = $id;
		$array['carrito'] = $carrito;
		$logcarritoModel = new Administracion_Model_DbTable_Logcarrito();
		$socio = Session::getInstance()->get('socio');
		$data['log_cedula'] = $socio ? $socio->SBE_CODI : null;
		$data['log_detalle'] = "Borrar del carrito";
		$data['log_log'] = print_r($array, true);
		$data['log_fecha'] = date("Y-m-d H:i:s");
		$logcarritoModel->insert($data);
	}

	public function changecantidadAction()
	{
		$this->setLayout("blanco");
		header('Content-Type: application/json');
		$id = $this->_getSanitizedParam("producto");
		$cantidad = $this->_getSanitizedParam("cantidad");
		$productoModel = new Administracion_Model_DbTable_Productos();
		$productoInfo = $productoModel->getById($id);
		if (!$productoInfo) {
			echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
			return;
		}
		$limite = $productoInfo->producto_limite_pedido ?? 0;
		if ($limite > 0 && $cantidad > $limite) {
			echo json_encode(['success' => false, 'message' => 'No se puede establecer más de ' . $limite . ' unidades de este producto.']);
			return;
		}
		$carrito = $this->getCarrito();
		if ($carrito[$id]) {
			$carrito[$id] = $cantidad;
		}
		Session::getInstance()->set("carrito", $carrito);

		//log carrito
		$array['id'] = $id;
		$array['cantidad'] = $cantidad;
		$array['carrito'] = $carrito;
		$logcarritoModel = new Administracion_Model_DbTable_Logcarrito();
		$socio = Session::getInstance()->get('socio');
		$data['log_cedula'] = $socio ? $socio->SBE_CODI : null;
		$data['log_detalle'] = "Cambiar cantidad carrito";
		$data['log_log'] = print_r($array, true);
		$data['log_fecha'] = date("Y-m-d H:i:s");
		$logcarritoModel->insert($data);
		echo json_encode(['success' => true]);
	}

	public function getCarritoJsonAction()
	{
		$this->setLayout("blanco");
		header('Content-Type: application/json');

		$productoModel = new Administracion_Model_DbTable_Productos();
		$carrito = $this->getCarrito();
		$impuestosModel = new Administracion_Model_DbTable_Impuestos();

		$impuestos = $impuestosModel->getList('impuesto_estado = 1', 'impuesto_nombre ASC');

		$porcentajeImpuesto = 0;
		if (is_countable($impuestos) && count($impuestos) > 0) {
			foreach ($impuestos as $impuesto) {
				$porcentajeImpuesto += $impuesto->impuesto_porcentaje;
			}
		}

		$data = [];
		foreach ($carrito as $id => $cantidad) {
			$productoInfo = $productoModel->getById($id);
			if (!$productoInfo) {
				continue;
			}
			if (empty($productoInfo->producto_imagen) || !file_exists(PUBLIC_PATH . '/images/' . $productoInfo->producto_imagen)) {
				$productoInfo->producto_imagen = 'product.gif';
			}
			$productoInfo->producto_precio = $productoInfo->producto_precio + ($productoInfo->producto_precio * ($porcentajeImpuesto / 100));

			$data[] = [
				'id' => $productoInfo->producto_id,
				'nombre' => $productoInfo->producto_nombre,
				'imagen' => $productoInfo->producto_imagen,
				'precio' => $productoInfo->producto_precio,
				'cantidad' => (int) $cantidad
			];
		}

		echo json_encode($data);
	}
}
