<?php

/**
 *
 */

class Page_activacionController extends Page_mainController
{

  public function indexAction()
  {
    $code = 'KIOSKO_001';
    $pin = '202601';

    $kioskoModel = new Administracion_Model_DbTable_Kioskos();
    $kiosko = $kioskoModel->getList("kiosko_codigo = '$code' AND kiosko_estado = 1", "")[0];

    if (password_verify($pin, $kiosko->kiosko_pin)) {
      // Guardar cookie de activación por 5 años
      setcookie(
        'kiosk_id',
        $kiosko->kiosko_id,
        time() + (5 * 365 * 24 * 60 * 60),
        '/'
      );

      $kioskoModel->editField($kiosko->kiosko_id, 'kiosko_fecha_activacion', date('Y-m-d H:i:s'));

      header("Location: /");
      return;
    }


  }
}
