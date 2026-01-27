<?php 
/**
* clase que genera la clase dependiente  de pedidoproductos en la base de datos
*/
class Administracion_Model_DbTable_Dependpedidos extends Db_Table
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

}