<?php

abstract class Controllers_Abstract
{
  protected $_response;
  protected $_request;
  protected $_routes;

  protected $_action;
  protected $_view;
  protected $_viewFilename;
  protected $_layout = null;
  protected $_csrf;
  protected $_csrf_section = "general";


  function __construct($res, $req, $rou)
  {
    $this->setResponse($res);
    $this->setRequest($req);
    $this->setRoutes($rou);
    $module = $this->getRoutes()->getModule();
    $controller = $this->getRoutes()->getController();
    $view = $this->getRoutes()->getAction();
    $csrf = $this->_getSanitizedParam("csrf");
    if ($this->_getSanitizedParam("csrf") == '') {
      $this->_csrf = new Core_Model_Csrf($this->_csrf_section);
    }
    $this->_viewFilename = APP_PATH . '/modules/' . $module . '/Views/' . $controller . '/' . $view . '.php';
    $this->_view = new View();
    $this->init();
  }
  public function init() {}

  protected function _getSanitizedParam($name, $value = null)
  {
    $currentValue = $this->getRequest()->_getParam($name, $value);
    $currentValue = strip_tags($currentValue ?? ''); // Elimina etiquetas HTML
    $currentValue = trim($currentValue); // Elimina espacios en blanco al inicio y al final
    $currentValue = mysqli_real_escape_string(App::getDbConnection()->getConnection(), $currentValue); // Escapa para SQL

    $patterns = [
      "/(union.*select.*)/i",
      "/(select.*from.*)/i",
      "/(insert.*into.*values.*)/i",
      "/(drop.*table.*)/i",
      "/(--.*)/i",
      // "/(#.*)/i",
      "/(\*.*from.*)/i",
      "/(concat.*\()/i",
      "/(load_file.*\()/i",
      "/(outfile.*\()/i",
      "/(sleep.*\()/i",
      "/(benchmark.*\()/i",
      "/(union.*all.*select.*)/i",
      "/(drop.*database.*)/i",
      "/(alter.*table.*)/i",
      "/(update.*set.*)/i",
      "/(delete.*from.*)/i",
      "/(select.*into.*outfile.*)/i",
      "/(select.*into.*dumpfile.*)/i",
      "/(information_schema.*)/i",
      "/(database\(\))/i",
      "/(version\(\))/i",
    ];
    foreach ($patterns as $pattern) {
      $currentValue = preg_replace($pattern, '', $currentValue);
    }
    return $currentValue;
  }

  protected function _getSanitizedParamHtml($name, $value = null)
  {
    $currentValue = $this->getRequest()->_getParam($name, $value);
    // Eliminar el texto no deseado
    $currentValue = str_replace('<script src="//cdn.public.flmngr.com/FLMNFLMN/widgets.js"></script>', '', $currentValue);
    $currentValue = str_replace('<script src="//cdn.flmngr.com/widgets.js?apiKey=FLMNFLMN"></script>', '', $currentValue);
    // Usar regex para eliminar cualquier script que coincida con el patrón
    $pattern = '/<script src="\/\/cdn\.(?:public\.)?flmngr\.com\/(?:FLMNFLMN\/widgets\.js|widgets\.js\?apiKey=FLMNFLMN(?:[^"]*?))"[^>]*><\/script>/';
    $currentValue = preg_replace($pattern, '', $currentValue);
    $currentValue = addslashes($currentValue ?? '');
    $currentValue = trim($currentValue);
    return $currentValue;
  }

  protected function _getSanitizedValue($currentValue)
  {
    $currentValue = addslashes($currentValue ?? '');
    $currentValue = strip_tags($currentValue ?? '');
    $currentValue = trim($currentValue);
    $currentValue = htmlentities($currentValue);

    return $currentValue;
  }

  public function getResponse()
  {
    return $this->_response;
  }

  public function getRequest()
  {
    return $this->_request;
  }

  public function getRoutes()
  {
    return $this->_routes;
  }
  public function getAction()
  {
    return $this->_action;
  }
  public function setResponse($res)
  {
    $this->_response = $res;
  }

  public function setRequest($req)
  {
    $this->_request = $req;
  }

  public function setRoutes($rou)
  {
    $this->_routes = $rou;
  }

  public function render()
  {

    if (null != $this->_layout) {
      $this->_layout->setView($this->_view);
      return $this->_layout->render($this->_viewFilename);
    }
    return $this->_view->render($this->_viewFilename);
  }

  public function setLayout($layoutName)
  {
    $this->_layout = new Layout($layoutName);
  }

  public function getLayout()
  {
    return $this->_layout;
  }
}
