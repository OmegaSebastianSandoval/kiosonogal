<?php
/**
* Controlador de Pedidos que permite la  creacion, edicion  y eliminacion de los pedidos del Sistema
*/
class Administracion_pedidosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos pedidos
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
	protected $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_pedidos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador pedidos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Pedidos();
		$this->namefilter = "parametersfilterpedidos";
		$this->route = "/administracion/pedidos";
		$this->namepages ="pages_pedidos";
		$this->namepageactual ="page_actual_pedidos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  pedidos con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de pedidos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
		   	$page = Session::getInstance()->get($this->namepageactual);
		   	$start = ($page - 1) * $amount;
		} else if(!$page){
			$start = 0;
		   	$page=1;
			Session::getInstance()->set($this->namepageactual,$page);
		} else {
			Session::getInstance()->set($this->namepageactual,$page);
		   	$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list)/$amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  pedido  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_pedidos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->pedido_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar pedido";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear pedido";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear pedido";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un pedido  y redirecciona al listado de pedidos.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['pedido_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR PEDIDO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un pedido  y redirecciona al listado de pedidos.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->pedido_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['pedido_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR PEDIDO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un pedido  y redirecciona al listado de pedidos.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR PEDIDO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Pedidos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['pedido_documento'] = $this->_getSanitizedParam("pedido_documento");
		$data['pedido_nombre'] = $this->_getSanitizedParam("pedido_nombre");
		$data['pedido_correo'] = $this->_getSanitizedParam("pedido_correo");
		$data['pedido_celular'] = $this->_getSanitizedParam("pedido_celular");
		$data['pedido_propina'] = $this->_getSanitizedParam("pedido_propina");
		$data['pedido_fecha'] = $this->_getSanitizedParam("pedido_fecha");
		if($this->_getSanitizedParam("pedido_valorpagar") == '' ) {
			$data['pedido_valorpagar'] = '0';
		} else {
			$data['pedido_valorpagar'] = $this->_getSanitizedParam("pedido_valorpagar");
		}
		if($this->_getSanitizedParam("pedido_estado") == '' ) {
			$data['pedido_estado'] = '0';
		} else {
			$data['pedido_estado'] = $this->_getSanitizedParam("pedido_estado");
		}
		$data['pedido_estado_texto'] = $this->_getSanitizedParam("pedido_estado_texto");
		$data['pedido_estado_texto2'] = $this->_getSanitizedParam("pedido_estado_texto2");
		$data['pedido_cus'] = $this->_getSanitizedParam("pedido_cus");
		$data['pedido_franquicia'] = $this->_getSanitizedParam("pedido_franquicia");
		$data['pedido_medio'] = $this->_getSanitizedParam("pedido_medio");
		$data['pedido_nombrefe'] = $this->_getSanitizedParam("pedido_nombrefe");
		$data['pedido_correofe'] = $this->_getSanitizedParam("pedido_correofe");
		$data['pedido_celularfe'] = $this->_getSanitizedParam("pedido_celularfe");
		$data['pedido_cuotas'] = $this->_getSanitizedParam("pedido_cuotas");
		$data['pedido_request_id'] = $this->_getSanitizedParam("pedido_request_id");
		$data['pedido_ip'] = $this->_getSanitizedParam("pedido_ip");
		$data['pedido_numeroaccion'] = $this->_getSanitizedParam("pedido_numeroaccion");
		$data['pedido_observacion'] = $this->_getSanitizedParam("pedido_observacion");
		$data['pedido_lugar'] = $this->_getSanitizedParam("pedido_lugar");
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
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
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
        if ($this->getRequest()->isPost()== true) {
        	Session::getInstance()->set($this->namepageactual,1);
            $parramsfilter = array();Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}