<?php

/**
 * Controlador para validar el número de carnet
 */

class Page_validarController extends Page_mainController
{

  public function indexAction()
  {
    $this->setLayout('blanco'); // Removido para evitar HTML en respuesta JSON

    $numeroCarnet = isset($_POST['numeroCarnet']) ? $_POST['numeroCarnet'] : '';
    $hash = isset($_POST['hash']) ? $_POST['hash'] : '';

    $expectedHash = md5('totem_secret_omega' . date('Y-m-d'));
    if ($hash !== $expectedHash) {
      echo json_encode(['success' => false, 'message' => 'Hash de seguridad inválido.']);
      exit();
    }

    $numeroCarnet = preg_replace('/[^0-9]/', '', trim($numeroCarnet));
    $numeroCarnet = $this->getSanitizedParam($numeroCarnet);

    if (!is_numeric($numeroCarnet) || strlen($numeroCarnet) < 5 || strlen($numeroCarnet) > 8) {
      echo json_encode(['success' => false, 'message' => 'El número de carnet debe ser numérico y tener entre 5 y 8 dígitos.']);
      exit();
    }

    if (substr($numeroCarnet, -2) === '00') {
      echo json_encode(['success' => false, 'message' => 'El número de carnet no es válido.']);
      exit();
    }



    try {
      $res = $this->consultarSocio($numeroCarnet);


      if ($res->mensaje == "No encontrado") {
        throw new Exception('Número de carnet no encontrado.');

      }
      $socioData = $res;
      if (!$socioData || !$socioData->SBE_CODI) {
        throw new Exception('Número de carnet no encontrado.');
      }
      $beneficiarios = $this->consultarBeneficiarios($socioData->MAC_NUME);
      if (is_countable($beneficiarios) && count($beneficiarios) > 0) {

        foreach ($beneficiarios as $beneficiario) {
          if ($beneficiario->SBE_CODI === $socioData->SBE_CODI) {
            $socioData->SBE_CUPO = $beneficiario->SBE_CUPO;
            break;
          }
        }
      }

      Session::getInstance()->set('socio', $socioData);
      echo json_encode(['success' => true, 'message' => 'Número de carnet validado correctamente.', 'redirect' => '/page/productos?popup=1']);
    } catch (Exception $e) {
      echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
  }

  protected function getSanitizedParam($currentValue)
  {
    $currentValue = strip_tags($currentValue ?? '');
    $currentValue = trim($currentValue);
    $currentValue = mysqli_real_escape_string(App::getDbConnection()->getConnection(), $currentValue);

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
}
