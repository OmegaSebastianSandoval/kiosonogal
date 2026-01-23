<?php 
/**
* clase que genera la insercion y edicion  de categoria en la base de datos
*/
class Administracion_Model_DbTable_Categorias extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'categorias';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'categoria_id';

	/**
	 * insert recibe la informacion de un categoria y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$categoria_nombre = $data['categoria_nombre'];
		$categoria_imagen = $data['categoria_imagen'];
		$categoria_descripcion = $data['categoria_descripcion'];
		$categoria_padre = $data['categoria_padre'];
		$categoria_estado = $data['categoria_estado'];
		$query = "INSERT INTO categorias( categoria_nombre, categoria_imagen, categoria_descripcion, categoria_padre, categoria_estado) VALUES ( '$categoria_nombre', '$categoria_imagen', '$categoria_descripcion', '$categoria_padre', '$categoria_estado')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un categoria  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$categoria_nombre = $data['categoria_nombre'];
		$categoria_imagen = $data['categoria_imagen'];
		$categoria_descripcion = $data['categoria_descripcion'];
		$categoria_padre = $data['categoria_padre'];
		$categoria_estado = $data['categoria_estado'];
		$query = "UPDATE categorias SET  categoria_nombre = '$categoria_nombre', categoria_imagen = '$categoria_imagen', categoria_descripcion = '$categoria_descripcion', categoria_padre = '$categoria_padre', categoria_estado = '$categoria_estado' WHERE categoria_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}