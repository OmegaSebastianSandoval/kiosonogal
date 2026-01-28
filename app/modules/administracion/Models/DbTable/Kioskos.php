<?php
/**
 * clase que genera la insercion y edicion  de kioskos en la base de datos
 */
class Administracion_Model_DbTable_Kioskos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'kioskos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'kiosko_id';

	/**
	 * insert recibe la informacion de un kiosko y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$kiosko_codigo = $data['kiosko_codigo'];
		$kiosko_estado = $data['kiosko_estado'];
		$kiosko_localizacion = $data['kiosko_localizacion'];
		$kiosko_fecha_activacion = $data['kiosko_fecha_activacion'];
		$kiosko_pin = password_hash($data['kiosko_pin'], PASSWORD_DEFAULT);
		$query = "INSERT INTO kioskos( kiosko_codigo, kiosko_estado, kiosko_localizacion, kiosko_fecha_activacion, kiosko_pin) VALUES ( '$kiosko_codigo', '$kiosko_estado', '$kiosko_localizacion', '$kiosko_fecha_activacion', '$kiosko_pin')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un kiosko  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$kiosko_codigo = $data['kiosko_codigo'];
		$kiosko_estado = $data['kiosko_estado'];
		$kiosko_localizacion = $data['kiosko_localizacion'];
		$kiosko_fecha_activacion = $data['kiosko_fecha_activacion'];
		$changepin = '';
		if ($data['kiosko_pin'] != '') {
			$kiosko_pin = password_hash($data['kiosko_pin'], PASSWORD_DEFAULT);
			$changepin = " , kiosko_pin = '$kiosko_pin'";
		}
		$query = "UPDATE kioskos SET  kiosko_codigo = '$kiosko_codigo', kiosko_estado = '$kiosko_estado', kiosko_localizacion = '$kiosko_localizacion', kiosko_fecha_activacion = '$kiosko_fecha_activacion' $changepin WHERE kiosko_id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

}