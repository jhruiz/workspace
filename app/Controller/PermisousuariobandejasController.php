<?php

App::uses('AppController', 'Controller');

/**
 * Permisousuariobandejas Controller
 *
 */
class PermisousuariobandejasController extends AppController {

    /**
     * Scaffold
     *
     * @var mixed
     */
    public $scaffold;

    public function add() {
        $this->autoRender = false;
        $postData = $this->request->data;
   
        $idUsuario = $postData['usuario_id'];
        $idBandeja = $postData['bandeja_id'];
        $idPermiso = $postData['permisobandeja_id'];

        $this->loadModel('Permisousuariobandeja');

        if($this->Permisousuariobandeja->obtenerPermisosUsrBandPerm($idBandeja, $idUsuario, $idPermiso)){
            $this->Permisousuariobandeja->agregarPermisoBandejasUsuario($idBandeja, $idUsuario, $idPermiso);
            $respuesta = '1';
        }else{
            $respuesta = '2';
        }        
        
        echo json_encode(array('respuesta' => $respuesta));
    }

    public function delete() {
        $this->autoRender = false;
        $postData = $this->request->data;

        $this->loadModel('Permisousuariobandeja');

        if ($this->Permisousuariobandeja->delete($postData['id'], false))
            echo json_encode(true);
        else
            echo json_encode(false);
    }
    
    public function ajaxListPermisoPorBandeja(){
        $this->autoRender = false;
        $postData = $this->request->data;
        $idBandeja = $postData['idBandeja'];
        
        $infoPermisosBandeja = $this->Permisousuariobandeja->obtenerPermisosUsuariosBandejas($idBandeja);

        echo json_encode(array('infoPermisosBandeja' => $infoPermisosBandeja));        
    }
    
    public function addPermisosPerfil(){
        $this->loadModel('Usuario');
        
        $this->autoRender = false;
        $postData = $this->request->data;
        
        $idPerfil = $postData['perfil_id'];
        $idBandeja = $postData['bandeja_id'];
        $idPermiso = $postData['permisobandeja_id'];
        $respuesta = '1';
        
        $idsUsuarioPorPerfil = $this->Usuario->obtenerUsuarioPorPerfil($idPerfil);
        if(count($idsUsuarioPorPerfil) > 0){
            for($i = 0; $i < count($idsUsuarioPorPerfil); $i++){
                if($this->Permisousuariobandeja->obtenerPermisosUsrBandPerm($idBandeja, $idsUsuarioPorPerfil[$i]['Usuario']['id'], $idPermiso)){
                    $this->Permisousuariobandeja->agregarPermisoBandejasUsuario($idBandeja, $idsUsuarioPorPerfil[$i]['Usuario']['id'], $idPermiso);
                }else{
                    continue;
                }
            }
        }else{
            $respuesta = '2';
        }
        
        echo json_encode(array('usuarios' => $respuesta));       
    }

}
