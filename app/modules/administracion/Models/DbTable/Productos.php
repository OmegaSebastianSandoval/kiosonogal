<?php

/**
 * clase que genera la insercion y edicion  de productos en la base de datos
 */
class Administracion_Model_DbTable_Productos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'productos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'producto_id';

	/**
	 * insert recibe la informacion de un producto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$producto_nombre = $data['producto_nombre'];
		$producto_descripcion = $data['producto_descripcion'];
		$producto_imagen = $data['producto_imagen'];
		$producto_destacado = $data['producto_destacado'];
		$producto_precio = $data['producto_precio'];
		$producto_nuevo = $data['producto_nuevo'];
		$producto_cantidad = $data['producto_cantidad'];
		$producto_categoria = $data['producto_categoria'];
		$producto_subcategoria = $data['producto_subcategoria'];
		$producto_estado = $data['producto_estado'];
		$producto_codigo = $data['producto_codigo'];
		$producto_cantidad_minima = $data['producto_cantidad_minima'];
		$producto_limite_pedido = $data['producto_limite_pedido'];
		$query = "INSERT INTO productos( producto_nombre, producto_descripcion, producto_imagen, producto_destacado, producto_precio, producto_nuevo, producto_cantidad, producto_categoria, producto_subcategoria, producto_estado, producto_codigo, producto_cantidad_minima, producto_limite_pedido) VALUES ( '$producto_nombre', '$producto_descripcion', '$producto_imagen', '$producto_destacado', '$producto_precio', '$producto_nuevo', '$producto_cantidad', '$producto_categoria', '$producto_subcategoria', '$producto_estado', '$producto_codigo', '$producto_cantidad_minima', '$producto_limite_pedido')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un producto  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$producto_nombre = $data['producto_nombre'];
		$producto_descripcion = $data['producto_descripcion'];
		$producto_imagen = $data['producto_imagen'];
		$producto_destacado = $data['producto_destacado'];
		$producto_precio = $data['producto_precio'];
		$producto_nuevo = $data['producto_nuevo'];
		$producto_cantidad = $data['producto_cantidad'];
		$producto_categoria = $data['producto_categoria'];
		$producto_subcategoria = $data['producto_subcategoria'];
		$producto_estado = $data['producto_estado'];
		$producto_codigo = $data['producto_codigo'];
		$producto_cantidad_minima = $data['producto_cantidad_minima'];
		$producto_limite_pedido = $data['producto_limite_pedido'];
		$query = "UPDATE productos SET  producto_nombre = '$producto_nombre', producto_descripcion = '$producto_descripcion', producto_imagen = '$producto_imagen', producto_destacado = '$producto_destacado', producto_precio = '$producto_precio', producto_nuevo = '$producto_nuevo', producto_cantidad = '$producto_cantidad', producto_categoria = '$producto_categoria', producto_subcategoria = '$producto_subcategoria', producto_estado = '$producto_estado', producto_codigo = '$producto_codigo', producto_cantidad_minima = '$producto_cantidad_minima', producto_limite_pedido = '$producto_limite_pedido' WHERE producto_id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}
}
