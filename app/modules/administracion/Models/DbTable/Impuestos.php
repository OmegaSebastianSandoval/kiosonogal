<?php 
/**
* clase que genera la insercion y edicion  de impuestos en la base de datos
*/
class Administracion_Model_DbTable_Impuestos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'impuestos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'impuesto_id';

	/**
	 * insert recibe la informacion de un impuesto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$impuesto_estado = $data['impuesto_estado'];
		$impuesto_nombre = $data['impuesto_nombre'];
		$impuesto_porcentaje = $data['impuesto_porcentaje'];
		$query = "INSERT INTO impuestos( impuesto_estado, impuesto_nombre, impuesto_porcentaje) VALUES ( '$impuesto_estado', '$impuesto_nombre', '$impuesto_porcentaje')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un impuesto  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$impuesto_estado = $data['impuesto_estado'];
		$impuesto_nombre = $data['impuesto_nombre'];
		$impuesto_porcentaje = $data['impuesto_porcentaje'];
		$query = "UPDATE impuestos SET  impuesto_estado = '$impuesto_estado', impuesto_nombre = '$impuesto_nombre', impuesto_porcentaje = '$impuesto_porcentaje' WHERE impuesto_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}