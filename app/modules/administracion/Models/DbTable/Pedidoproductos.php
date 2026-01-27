<?php 
/**
* clase que genera la insercion y edicion  de pedidoproductos en la base de datos
*/
class Administracion_Model_DbTable_Pedidoproductos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'pedido_productos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'pedido_producto_id';

	/**
	 * insert recibe la informacion de un pedidoproductos y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$pedido_producto_pedido = $data['pedido_producto_pedido'];
		$pedido_producto_producto = $data['pedido_producto_producto'];
		$pedido_producto_nombre = $data['pedido_producto_nombre'];
		$pedido_producto_imagen = $data['pedido_producto_imagen'];
		$pedido_producto_cantidad = $data['pedido_producto_cantidad'];
		$pedido_producto_valor = $data['pedido_producto_valor'];
		$pedido_producto_valor_impuestos = $data['pedido_producto_valor_impuestos'];
		$pedido_producto_valor_total = $data['pedido_producto_valor_total'];
		$pedido_producto_ingredientes = $data['pedido_producto_ingredientes'];
		$pedido_producto_ingredientes_ids = $data['pedido_producto_ingredientes_ids'];
		$query = "INSERT INTO pedido_productos( pedido_producto_pedido, pedido_producto_producto, pedido_producto_nombre, pedido_producto_imagen, pedido_producto_cantidad, pedido_producto_valor, pedido_producto_valor_impuestos, pedido_producto_valor_total, pedido_producto_ingredientes, pedido_producto_ingredientes_ids) VALUES ( '$pedido_producto_pedido', '$pedido_producto_producto', '$pedido_producto_nombre', '$pedido_producto_imagen', '$pedido_producto_cantidad', '$pedido_producto_valor', '$pedido_producto_valor_impuestos', '$pedido_producto_valor_total', '$pedido_producto_ingredientes', '$pedido_producto_ingredientes_ids')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un pedidoproductos  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$pedido_producto_pedido = $data['pedido_producto_pedido'];
		$pedido_producto_producto = $data['pedido_producto_producto'];
		$pedido_producto_nombre = $data['pedido_producto_nombre'];
		$pedido_producto_imagen = $data['pedido_producto_imagen'];
		$pedido_producto_cantidad = $data['pedido_producto_cantidad'];
		$pedido_producto_valor = $data['pedido_producto_valor'];
		$pedido_producto_valor_impuestos = $data['pedido_producto_valor_impuestos'];
		$pedido_producto_valor_total = $data['pedido_producto_valor_total'];
		$pedido_producto_ingredientes = $data['pedido_producto_ingredientes'];
		$pedido_producto_ingredientes_ids = $data['pedido_producto_ingredientes_ids'];
		$query = "UPDATE pedido_productos SET  pedido_producto_pedido = '$pedido_producto_pedido', pedido_producto_producto = '$pedido_producto_producto', pedido_producto_nombre = '$pedido_producto_nombre', pedido_producto_imagen = '$pedido_producto_imagen', pedido_producto_cantidad = '$pedido_producto_cantidad', pedido_producto_valor = '$pedido_producto_valor', pedido_producto_valor_impuestos = '$pedido_producto_valor_impuestos', pedido_producto_valor_total = '$pedido_producto_valor_total', pedido_producto_ingredientes = '$pedido_producto_ingredientes', pedido_producto_ingredientes_ids = '$pedido_producto_ingredientes_ids' WHERE pedido_producto_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}