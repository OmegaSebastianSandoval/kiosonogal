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
			$productoInfo->producto_precio = $productoInfo->producto_precio + ($productoInfo->producto_precio * ($porcentajeImpuesto / 100));


			$data[$id] = [];
			$data[$id]['detalle'] = $productoInfo;
			$data[$id]['cantidad'] = (int) $cantidad;

		}
		$this->_view->carrito = $data;
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
		if (!Session::getInstance()->get("socio")) return;
		$this->setLayout("blanco");
		$id = $this->_getSanitizedParam("producto");
		$cantidad = $this->_getSanitizedParam("cantidad");
		$carrito = $this->getCarrito();
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
		$id = $this->_getSanitizedParam("producto");
		$cantidad = $this->_getSanitizedParam("cantidad");
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
	}
}
