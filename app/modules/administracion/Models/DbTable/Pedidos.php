<?php
/**
 * clase que genera la insercion y edicion  de pedidos en la base de datos
 */
class Administracion_Model_DbTable_Pedidos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'pedidos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'pedido_id';

	/**
	 * insert recibe la informacion de un pedido y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$pedido_documento = $data['pedido_documento'];
		$pedido_nombre = $data['pedido_nombre'];
		$pedido_correo = $data['pedido_correo'];
		$pedido_celular = $data['pedido_celular'];
		$pedido_propina = $data['pedido_propina'];
		$pedido_fecha = $data['pedido_fecha'];
		$pedido_valorpagar = $data['pedido_valorpagar'];
		$pedido_estado = $data['pedido_estado'];
		$pedido_estado_texto = $data['pedido_estado_texto'];
		$pedido_estado_texto2 = $data['pedido_estado_texto2'];
		$pedido_cus = $data['pedido_cus'];
		$pedido_franquicia = $data['pedido_franquicia'];
		$pedido_medio = $data['pedido_medio'];
		$pedido_nombrefe = $data['pedido_nombrefe'];
		$pedido_correofe = $data['pedido_correofe'];
		$pedido_celularfe = $data['pedido_celularfe'];
		$pedido_cuotas = $data['pedido_cuotas'];
		$pedido_request_id = $data['pedido_request_id'];
		$pedido_ip = $data['pedido_ip'];
		$pedido_numeroaccion = $data['pedido_numeroaccion'];
		$pedido_observacion = $data['pedido_observacion'];
		$pedido_lugar = $data['pedido_lugar'];
		$pedido_estado_preparacion = $data['pedido_estado_preparacion'];
		$pedido_estado_preparacion_text = $data['pedido_estado_preparacion_text'];
		$pedido_kiosko = $data['pedido_kiosko'];
		$pedido_iva = $data['pedido_iva'];
		$pedido_impuestos = $data['pedido_impuestos'];

		$query = "INSERT INTO pedidos( pedido_documento, pedido_nombre, pedido_correo, pedido_celular, pedido_propina, pedido_fecha, pedido_valorpagar, pedido_estado, pedido_estado_texto, pedido_estado_texto2, pedido_cus, pedido_franquicia, pedido_medio, pedido_nombrefe, pedido_correofe, pedido_celularfe, pedido_cuotas, pedido_request_id, pedido_ip, pedido_numeroaccion, pedido_observacion, pedido_lugar, pedido_estado_preparacion, pedido_estado_preparacion_text, pedido_kiosko, pedido_iva, pedido_impuestos) VALUES ( '$pedido_documento', '$pedido_nombre', '$pedido_correo', '$pedido_celular', '$pedido_propina', '$pedido_fecha', '$pedido_valorpagar', '$pedido_estado', '$pedido_estado_texto', '$pedido_estado_texto2', '$pedido_cus', '$pedido_franquicia', '$pedido_medio', '$pedido_nombrefe', '$pedido_correofe', '$pedido_celularfe', '$pedido_cuotas', '$pedido_request_id', '$pedido_ip', '$pedido_numeroaccion', '$pedido_observacion', '$pedido_lugar', '$pedido_estado_preparacion', '$pedido_estado_preparacion_text', '$pedido_kiosko', '$pedido_iva', '$pedido_impuestos')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un pedido  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$pedido_documento = $data['pedido_documento'];
		$pedido_nombre = $data['pedido_nombre'];
		$pedido_correo = $data['pedido_correo'];
		$pedido_celular = $data['pedido_celular'];
		$pedido_propina = $data['pedido_propina'];
		$pedido_fecha = $data['pedido_fecha'];
		$pedido_valorpagar = $data['pedido_valorpagar'];
		$pedido_estado = $data['pedido_estado'];
		$pedido_estado_texto = $data['pedido_estado_texto'];
		$pedido_estado_texto2 = $data['pedido_estado_texto2'];
		$pedido_cus = $data['pedido_cus'];
		$pedido_franquicia = $data['pedido_franquicia'];
		$pedido_medio = $data['pedido_medio'];
		$pedido_nombrefe = $data['pedido_nombrefe'];
		$pedido_correofe = $data['pedido_correofe'];
		$pedido_celularfe = $data['pedido_celularfe'];
		$pedido_cuotas = $data['pedido_cuotas'];
		$pedido_request_id = $data['pedido_request_id'];
		$pedido_ip = $data['pedido_ip'];
		$pedido_numeroaccion = $data['pedido_numeroaccion'];
		$pedido_observacion = $data['pedido_observacion'];
		$pedido_lugar = $data['pedido_lugar'];
		$pedido_estado_preparacion = $data['pedido_estado_preparacion'];
		$pedido_estado_preparacion_text = $data['pedido_estado_preparacion_text'];
		$pedido_kiosko = $data['pedido_kiosko'];
		$pedido_iva = $data['pedido_iva'];
		$pedido_impuestos = $data['pedido_impuestos'];

		$query = "UPDATE pedidos SET  pedido_documento = '$pedido_documento', pedido_nombre = '$pedido_nombre', pedido_correo = '$pedido_correo', pedido_celular = '$pedido_celular', pedido_propina = '$pedido_propina', pedido_fecha = '$pedido_fecha', pedido_valorpagar = '$pedido_valorpagar', pedido_estado = '$pedido_estado', pedido_estado_texto = '$pedido_estado_texto', pedido_estado_texto2 = '$pedido_estado_texto2', pedido_cus = '$pedido_cus', pedido_franquicia = '$pedido_franquicia', pedido_medio = '$pedido_medio', pedido_nombrefe = '$pedido_nombrefe', pedido_correofe = '$pedido_correofe', pedido_celularfe = '$pedido_celularfe', pedido_cuotas = '$pedido_cuotas', pedido_request_id = '$pedido_request_id', pedido_ip = '$pedido_ip', pedido_numeroaccion = '$pedido_numeroaccion', pedido_observacion = '$pedido_observacion', pedido_lugar = '$pedido_lugar', pedido_estado_preparacion = '$pedido_estado_preparacion', pedido_estado_preparacion_text = '$pedido_estado_preparacion_text', pedido_kiosko = '$pedido_kiosko', pedido_iva = '$pedido_iva', pedido_impuestos = '$pedido_impuestos' WHERE pedido_id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}


	public function actualizarEstadoPedido($pedidoId, $estado, $mensaje1, $mensaje2, $estadoPreparacion, $respuestaDatadono)
	{
		$query = "UPDATE pedidos SET  pedido_estado = '$estado', pedido_estado_texto = '$mensaje1', pedido_estado_texto2 = '$mensaje2', pedido_estado_preparacion = '$estadoPreparacion', pedido_res_datafono = '$respuestaDatadono' WHERE pedido_id = '" . $pedidoId . "'";
		$res = $this->_conn->query($query);
	}
}