<?php 
/**
* clase que genera la insercion y edicion  de logcarrito en la base de datos
*/
class Administracion_Model_DbTable_Logcarrito extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'log_carrito';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'log_id';

	/**
	 * insert recibe la informacion de un logcarrito y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$log_cedula = $data['log_cedula'];
		$log_detalle = $data['log_detalle'];
		$log_log = $data['log_log'];
		$log_fecha = $data['log_fecha'];
		$query = "INSERT INTO log_carrito( log_cedula, log_detalle, log_log, log_fecha) VALUES ( '$log_cedula', '$log_detalle', '$log_log', '$log_fecha')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un logcarrito  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$log_cedula = $data['log_cedula'];
		$log_detalle = $data['log_detalle'];
		$log_log = $data['log_log'];
		$log_fecha = $data['log_fecha'];
		$query = "UPDATE log_carrito SET  log_cedula = '$log_cedula', log_detalle = '$log_detalle', log_log = '$log_log', log_fecha = '$log_fecha' WHERE log_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}