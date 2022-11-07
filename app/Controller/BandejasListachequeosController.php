<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Menu');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 * @property PaginatorComponent $Paginator
 */
class BandejasListachequeosController extends AppController {

   /**
     * Obtiene el listado de items configurados
     */
    public function ajaxListItems(){
        $this->loadModel('Listachequeo');
        $this->autoRender = false;
        $postData = $this->request->data;
        $idBandeja = $postData['idBandeja'];

        // obtiene las listas de chequeos configuradas en la aplicacion
        $itemsChek = $this->Listachequeo->obtenerListasChequeo();

        // obtiene la lista configurada para una bandeja especifica
        $itemsBandeja = $this->BandejasListachequeo->obtenerItemsBandeja($idBandeja);

        foreach($itemsChek as $key => $val) {
            
            foreach($itemsBandeja as $keyj => $valj){
                if($val['Listachequeo']['id'] == $valj['BandejasListachequeo']['listachequeo_id']){
                    $itemsChek[$key]['Listachequeo']['checked'] = '1';
                }
            }
        }

        echo json_encode(array('itemsChek' => $itemsChek));        
    }

    /**
     * Agrega item a la bandeja
     */
    public function agregaritembandeja(){
        
        $this->autoRender = false;
        $postData = $this->request->data;
        $idBandeja = $postData['bandeja'];
        $idItem = $postData['item'];

        $resp = $this->BandejasListachequeo->agregarItembandeja($idBandeja, $idItem);

        echo json_encode(array('resp' => $resp));
    }

    /**
     * Elimina el item de una bandeja
     */
    public function eliminaritembandeja(){
        $this->autoRender = false;
        $postData = $this->request->data;
        $idBandeja = $postData['bandeja'];
        $idItem = $postData['item'];

        $resp = $this->BandejasListachequeo->eliminarItembandeja($idBandeja, $idItem);

        echo json_encode(array('resp', $resp));
    }
        
}

 