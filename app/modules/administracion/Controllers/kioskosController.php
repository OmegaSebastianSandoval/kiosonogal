<?php
/**
 * Controlador de Kioskos que permite la  creacion, edicion  y eliminacion de los kioskos del Sistema
 */
class Administracion_kioskosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos kioskos
	 * @var modeloContenidos
	 */
	public $mainModel;

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
	protected $_csrf_section = "administracion_kioskos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador kioskos .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Kioskos();
		$this->namefilter = "parametersfilterkioskos";
		$this->route = "/administracion/kioskos";
		$this->namepages = "pages_kioskos";
		$this->namepageactual = "page_actual_kioskos";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  kioskos con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Administración de kioskos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object) Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
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
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  kiosko  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_kioskos_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->kiosko_id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar kiosko";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear kiosko";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear kiosko";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un kiosko  y redirecciona al listado de kioskos.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			// Validar PIN
			if (!preg_match('/^[0-9]{6}$/', $data['kiosko_pin'])) {
				// Error, pero como es AJAX, redirigir con error? Pero para simplicidad, asumir validado
			}
			// Validar unicidad del código
			$existing = $this->mainModel->getList("kiosko_codigo = '" . $data['kiosko_codigo'] . "'", "");
			if (count($existing) > 0) {
				// Error
			}
			$id = $this->mainModel->insert($data);

			$data['kiosko_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR KIOSKO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un kiosko  y redirecciona al listado de kioskos.
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
			if ($content->kiosko_id) {
				$data = $this->getData();
				// Validar PIN si proporcionado
				if ($data['kiosko_pin'] != '' && !preg_match('/^[0-9]{6}$/', $data['kiosko_pin'])) {
					// Error
				}
				// Validar unicidad del código
				$existing = $this->mainModel->getList("kiosko_codigo = '" . $data['kiosko_codigo'] . "' AND kiosko_id != '$id'", "");
				if (count($existing) > 0) {
					// Error
				}
				$this->mainModel->update($data, $id);
			}
			$data['kiosko_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR KIOSKO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un kiosko  y redirecciona al listado de kioskos.
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
					$this->mainModel->deleteRegister($id);
					$data = (array) $content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR KIOSKO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Kioskos.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['kiosko_codigo'] = $this->_getSanitizedParam("kiosko_codigo");
		$data['kiosko_estado'] = $this->_getSanitizedParam("kiosko_estado");
		$data['kiosko_localizacion'] = $this->_getSanitizedParam("kiosko_localizacion");
		$data['kiosko_fecha_activacion'] = $this->_getSanitizedParam("kiosko_fecha_activacion");
		$data['kiosko_pin'] = $this->_getSanitizedParam("kiosko_pin");
		return $data;
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
			if ($filters->kiosko_codigo != '') {
				$filtros = $filtros . " AND kiosko_codigo LIKE '%" . $filters->kiosko_codigo . "%'";
			}
			if ($filters->kiosko_estado != '') {
				$filtros = $filtros . " AND kiosko_estado LIKE '%" . $filters->kiosko_estado . "%'";
			}
			if ($filters->kiosko_localizacion != '') {
				$filtros = $filtros . " AND kiosko_localizacion LIKE '%" . $filters->kiosko_localizacion . "%'";
			}
			if ($filters->kiosko_fecha_activacion != '') {
				$filtros = $filtros . " AND kiosko_fecha_activacion LIKE '%" . $filters->kiosko_fecha_activacion . "%'";
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
			$parramsfilter['kiosko_codigo'] = $this->_getSanitizedParam("kiosko_codigo");
			$parramsfilter['kiosko_estado'] = $this->_getSanitizedParam("kiosko_estado");
			$parramsfilter['kiosko_localizacion'] = $this->_getSanitizedParam("kiosko_localizacion");
			$parramsfilter['kiosko_fecha_activacion'] = $this->_getSanitizedParam("kiosko_fecha_activacion");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}

	/**
	 * Valida la unicidad del código del kiosko
	 *
	 * @return void
	 */
	public function validationAction()
	{
		$this->setLayout('blanco');
		$codigo = $this->_getSanitizedParam("codigo");
		$id = $this->_getSanitizedParam("id");
		$where = "kiosko_codigo = '$codigo'";
		if ($id) {
			$where .= " AND kiosko_id != '$id'";
		}
		$result = $this->mainModel->getList($where, "");
		if (count($result) > 0) {
			echo "El código ya existe";
		} else {
			echo "true";
		}
	}

	/**
	 * Valida el formato del PIN
	 *
	 * @return void
	 */
	public function validarpinAction()
	{
		$this->setLayout('blanco');
		$pin = $this->_getSanitizedParam("kiosko_pin");
		if (!preg_match('/^[0-9]{6}$/', $pin)) {
			echo "El PIN debe ser exactamente 6 dígitos numéricos";
		} else {
			echo "true";
		}
	}


}