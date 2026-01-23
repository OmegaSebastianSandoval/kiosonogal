<?php

/**
 *
 */

class Page_mainController extends Controllers_Abstract
{

	public $template;

	public function init()
	{
		$this->setLayout('page_page');
		$this->template = new Page_Model_Template_Template($this->_view);
		$infopageModel = new Page_Model_DbTable_Informacion();

		$informacion = $infopageModel->getById(1);
		$this->_view->infopage = $informacion;
		$this->getLayout()->setData("meta_description", "$informacion->info_pagina_descripcion");
		$this->getLayout()->setData("meta_keywords", "$informacion->info_pagina_tags");
		$this->getLayout()->setData("scripts", "$informacion->info_pagina_scripts");
		$botonesModel = new Page_Model_DbTable_Publicidad();
		$this->_view->botones = $botonesModel->getList("publicidad_seccion='3' AND publicidad_estado='1'", "orden ASC");

		$categoriasModel = new Administracion_Model_DbTable_Categorias();
		$categorias = $categoriasModel->getList('categoria_estado = 1', 'categoria_nombre ASC');

		$categoriasPadre = [];
		$subcategoriasPorPadre = [];

		foreach ($categorias as $categoria) {
			if (
				empty($categoria->categoria_imagen) ||
				!file_exists(PUBLIC_PATH . '/images/' . $categoria->categoria_imagen)
			) {
				$categoria->categoria_imagen = 'default_category.jpg';
			}
			if ((int) $categoria->categoria_padre === 0) {
				$categoria->subcategorias = []; // importante
				$categoriasPadre[$categoria->categoria_id] = $categoria;
			} else {
				$subcategoriasPorPadre[$categoria->categoria_padre][] = $categoria;
			}
		}
		foreach ($categoriasPadre as $idPadre => $categoriaPadre) {
			if (isset($subcategoriasPorPadre[$idPadre])) {
				$categoriaPadre->subcategorias = $subcategoriasPorPadre[$idPadre];
			}
		}

		$this->_view->socio = $socio = Session::getInstance()->get('socio');
		$this->getLayout()->setData("socio", $socio);

		$this->_view->categoriasList = array_values($categoriasPadre);

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header", $header);
		$enlaceModel = new Page_Model_DbTable_Enlace();
		$this->_view->enlaces = $enlaceModel->getList("", "orden ASC");
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footer.php');
		$this->getLayout()->setData("footer", $footer);
		$adicionales = $this->_view->getRoutPHP('modules/page/Views/partials/adicionales.php');
		$this->getLayout()->setData("adicionales", $adicionales);
		$this->usuario();
	}


	public function usuario()
	{
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if ($user->user_id == 1) {
			$this->editarpage = 1;
		}
	}
	public function consultarSocio($ncar)
	{
		$loginServiceUrl = URL_WS . '/querys/buscarUsuario.php';
		$postData = http_build_query([
			'token' => $this->generarToken(),
			'ncar' => $ncar
		]);

		$ch = curl_init($loginServiceUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			throw new Exception('Error al consultar socio: ' . curl_error($ch));
		}

		curl_close($ch);

		$response = json_decode($response);
		return $response;
	}

	public function generarToken()
	{
		$loginServiceUrl = 'https://ev.clubelnogal.com/tokens/querys/consultar_token.php';

		// Datos a enviar al servicio externo
		$postData = http_build_query([
			'inputUsername' => 'webnogal', //tken que recibe de la base de
			'inputPassword' => 'nogal2023*'
		]);

		$ch = curl_init($loginServiceUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			throw new Exception('Error al generar token: ' . curl_error($ch));
		}

		curl_close($ch);

		$response = json_decode($response);
		return $response->token;
	}
	 public function consultarBeneficiarios($mac_nume)
  {

    // $codi = Session::getInstance()->get('codi');
    // $ncar = Session::getInstance()->get('ncar');

    $loginServiceUrl = URL_WS . '/querys/selectBeneficiarios.php';

    // Datos a enviar al servicio externo
    $postData = http_build_query([
      'token' => $this->generarToken(), //tken que recibe de la base de
      'mac_nume' => $mac_nume
    ]);

    $ch = curl_init($loginServiceUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $response = json_decode($response);

    if (curl_errno($ch)) {
      echo 'Error cURL: ' . curl_error($ch);
      exit;
    }

    curl_close($ch);

    return $response;
  }

}