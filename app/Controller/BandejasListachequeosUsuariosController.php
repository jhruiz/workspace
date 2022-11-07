<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Menu');

class BandejasListachequeosUsuariosController extends AppController {

/**
 * Agrega el registro del check de la bandeja
 */
public function agregaritembandejausuario() { 

    $this->autoRender = false;
    $postData = $this->request->data;
    $idBandeja = $postData['bandeja'];
    $idItem = $postData['item'];
    $paqueteId = $postData['paqueteId'];
    $usuarioId = $this->Auth->user('id');
    $date = date('Y-m-d H:i:s');

    $resp = $this->BandejasListachequeosUsuario->agregarItembandejaUsr($idBandeja, $idItem, $usuarioId, $date, $paqueteId);

    echo json_encode(array('resp' => $resp, 'username' => $this->Auth->user('nombre'), 'date' => $date));             
}

/**
 * Elimina el registro del check de la bandeja
 */
public function eliminaritembandejausuario() {              
    $this->autoRender = false;
    $postData = $this->request->data;
    $idBandeja = $postData['bandeja'];
    $idItem = $postData['item'];
    $paqueteId = $postData['paqueteId'];
    $usuarioId = $this->Auth->user('id');

    $resp = $this->BandejasListachequeosUsuario->eliminarItembandejaUsr($idBandeja, $idItem, $usuarioId, $paqueteId);

    echo json_encode(array('resp' => $resp));        
}

}