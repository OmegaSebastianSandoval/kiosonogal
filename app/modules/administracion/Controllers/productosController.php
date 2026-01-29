<?php

/**
 * Controlador de Productos que permite la  creacion, edicion  y eliminacion de los productos del Sistema
 */
class Administracion_productosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos productos
	 * @var modeloContenidos
	 */
	public $mainModel;

	public $botonpanel = 6;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	protected $pages;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_productos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador productos .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Productos();
		$this->namefilter = "parametersfilterproductos";
		$this->route = "/administracion/productos";
		$this->namepages = "pages_productos";
		$this->namepageactual = "page_actual_productos";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  productos con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Administración de productos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "orden ASC";
		$list = $this->mainModel->getList($filters, $order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
			$page = Session::getInstance()->get($this->namepageactual);
			$start = ($page - 1) * $amount;
		} else if (!$page) {
			$start = 0;
			$page = 1;
			Session::getInstance()->set($this->namepageactual, $page);
		} else {
			Session::getInstance()->set($this->namepageactual, $page);
			$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list) / $amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters, $order, $start, $amount);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->list_producto_categoria = $this->getProductocategoria();
		$this->_view->list_producto_subcategoria = $this->getProductosubcategoria();
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  producto  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_productos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_producto_categoria = $this->getProductocategoria();
		$this->_view->list_producto_subcategoria = $this->getProductosubcategoria();
		$this->_view->subcategorias_por_categoria = $this->getSubcategoriasPorCategoria();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->producto_id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear producto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear producto";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un producto  y redirecciona al listado de productos.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$uploadImage = new Core_Model_Upload_Image();
			if ($_FILES['producto_imagen']['name'] != '') {
				$data['producto_imagen'] = $uploadImage->upload("producto_imagen");
			}
			$id = $this->mainModel->insert($data);
			$this->mainModel->changeOrder($id, $id);
			$data['producto_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un producto  y redirecciona al listado de productos.
	 *
	 * @return void.
	 */
	public function updateAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->producto_id) {
				$data = $this->getData();
				$uploadImage = new Core_Model_Upload_Image();
				if ($_FILES['producto_imagen']['name'] != '') {
					if ($content->producto_imagen) {
						$uploadImage->delete($content->producto_imagen);
					}
					$data['producto_imagen'] = $uploadImage->upload("producto_imagen");
				} else {
					$data['producto_imagen'] = $content->producto_imagen;
				}
				$this->mainModel->update($data, $id);
			}
			$data['producto_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR PRODUCTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un producto  y redirecciona al listado de productos.
	 *
	 * @return void.
	 */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$uploadImage = new Core_Model_Upload_Image();
					if (isset($content->producto_imagen) && $content->producto_imagen != '') {
						$uploadImage->delete($content->producto_imagen);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array) $content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR PRODUCTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Productos.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['producto_nombre'] = $this->_getSanitizedParam("producto_nombre");
		$data['producto_descripcion'] = $this->_getSanitizedParamHtml("producto_descripcion");
		$data['producto_imagen'] = "";
		$data['producto_destacado'] = $this->_getSanitizedParam("producto_destacado");
		$data['producto_precio'] = preg_replace('/[^\d]/', '', $this->_getSanitizedParam("producto_precio"));
		$data['producto_nuevo'] = $this->_getSanitizedParam("producto_nuevo");
		$data['producto_cantidad'] = $this->_getSanitizedParam("producto_cantidad");
		$data['producto_categoria'] = $this->_getSanitizedParam("producto_categoria");
		$data['producto_subcategoria'] = $this->_getSanitizedParam("producto_subcategoria");
		$data['producto_estado'] = $this->_getSanitizedParam("producto_estado");
		$data['producto_codigo'] = $this->_getSanitizedParam("producto_codigo");
		$data['producto_cantidad_minima'] = $this->_getSanitizedParam("producto_cantidad_minima");
		$data['producto_limite_pedido'] = $this->_getSanitizedParam("producto_limite_pedido");
		return $data;
	}

	/**
	 * Genera los valores del campo Categoria.
	 *
	 * @return array cadena con los valores del campo Categoria.
	 */
	private function getProductocategoria()
	{
		$modelData = new Administracion_Model_DbTable_Dependcategorias();
		$data = $modelData->getList("categoria_padre = 0 AND categoria_estado = 1");
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->categoria_id] = $value->categoria_nombre;
		}
		return $array;
	}


	/**
	 * Genera los valores del campo Subcategoria.
	 *
	 * @return array cadena con los valores del campo Subcategoria.
	 */
	private function getProductosubcategoria()
	{
		$modelData = new Administracion_Model_DbTable_Dependcategorias();
		$data = $modelData->getList(" categoria_estado = 1 ");
		$array = array();
		foreach ($data as $key => $value) {
			if ($value->categoria_padre) {
				$array[$value->categoria_id] = $value->categoria_nombre;
			}
		}
		return $array;
	}

	/**
	 * Genera las subcategorías agrupadas por categoría.
	 *
	 * @return array
	 */
	private function getSubcategoriasPorCategoria()
	{
		$modelData = new Administracion_Model_DbTable_Dependcategorias();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $value) {
			if ($value->categoria_padre) {
				$array[$value->categoria_padre][] = array('id' => $value->categoria_id, 'nombre' => $value->categoria_nombre);
			}
		}
		return $array;
	}

	/**
	 * Genera la consulta con los filtros de este controlador.
	 *
	 * @return array cadena con los filtros que se van a asignar a la base de datos
	 */
	protected function getFilter()
	{
		$filtros = " 1 = 1 ";
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object) Session::getInstance()->get($this->namefilter);
			if ($filters->producto_nombre != '') {
				$filtros = $filtros . " AND producto_nombre LIKE '%" . $filters->producto_nombre . "%'";
			}
			if ($filters->producto_imagen != '') {
				$filtros = $filtros . " AND producto_imagen LIKE '%" . $filters->producto_imagen . "%'";
			}
			if ($filters->producto_precio != '') {
				$filtros = $filtros . " AND producto_precio LIKE '%" . $filters->producto_precio . "%'";
			}
			if ($filters->producto_cantidad != '') {
				$filtros = $filtros . " AND producto_cantidad LIKE '%" . $filters->producto_cantidad . "%'";
			}
			if ($filters->producto_categoria != '') {
				$filtros = $filtros . " AND producto_categoria LIKE '%" . $filters->producto_categoria . "%'";
			}
			if ($filters->producto_subcategoria != '') {
				$filtros = $filtros . " AND producto_subcategoria LIKE '%" . $filters->producto_subcategoria . "%'";
			}
			if ($filters->producto_estado != '') {
				$filtros = $filtros . " AND producto_estado LIKE '%" . $filters->producto_estado . "%'";
			}
			if ($filters->producto_codigo != '') {
				$filtros = $filtros . " AND producto_codigo LIKE '%" . $filters->producto_codigo . "%'";
			}
		}
		return $filtros;
	}

	/**
	 * Recibe y asigna los filtros de este controlador
	 *
	 * @return void
	 */
	protected function filters()
	{
		if ($this->getRequest()->isPost() == true) {
			Session::getInstance()->set($this->namepageactual, 1);
			$parramsfilter = array();
			$parramsfilter['producto_nombre'] = $this->_getSanitizedParam("producto_nombre");
			$parramsfilter['producto_imagen'] = $this->_getSanitizedParam("producto_imagen");
			$parramsfilter['producto_precio'] = $this->_getSanitizedParam("producto_precio");
			$parramsfilter['producto_cantidad'] = $this->_getSanitizedParam("producto_cantidad");
			$parramsfilter['producto_categoria'] = $this->_getSanitizedParam("producto_categoria");
			$parramsfilter['producto_subcategoria'] = $this->_getSanitizedParam("producto_subcategoria");
			$parramsfilter['producto_estado'] = $this->_getSanitizedParam("producto_estado");
			$parramsfilter['producto_codigo'] = $this->_getSanitizedParam("producto_codigo");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
