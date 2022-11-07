<?php
App::uses('AppModel', 'Model');

class BandejasListachequeo extends AppModel {

    /**
     * obtiene los items configurados para una bandeja
     */
    public function obtenerItemsBandeja($idBandeja){
        $itemsBand = $this->find('all', array(
            'conditions' => array('BandejasListachequeo.bandeja_id' => $idBandeja),
            'recursive' => 0
        ));

        return $itemsBand;
    }

    /**
     * Agrega un nuevo item a la bandeja
     */
    public function agregarItembandeja($idBandeja, $idItem){
        $data=array();                        
                
        $bandejaItem = new BandejasListachequeo();                        
        
        $data['bandeja_id'] = $idBandeja;
        $data['listachequeo_id'] = $idItem;
        $data['created_at']= date('Y-m-d');
        
        if($bandejaItem->save($data)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Eliminar un item especifico de una bandeja
     */
    public function eliminarItembandeja($idBandeja, $idItem){

        $condiciones=array('BandejasListachequeo.bandeja_id' => $idBandeja, 'BandejasListachequeo.listachequeo_id' => $idItem);
        $resp = $this->deleteAll(array($condiciones),false);

        return $resp;
    }

    /**
     * Obtiene el listado de items mas la bandeja asociada a estos
     */
    public function obtenerListaItemsBandeja($bandejaId) {
        
        $arr_join = array();
        
        array_push($arr_join, array(
            'table' => 'listachequeos',
            'alias' => 'LC', 
            'type' => 'INNER',
            'conditions' => array(
                'LC.id=BandejasListachequeo.listachequeo_id')
        ));
        
        $arrListaBandeja = $this->find('all', array(
            'joins' => $arr_join,   
            'fields' => array(
                'LC.*',
                'BandejasListachequeo.*'
            ),
            'conditions' => array(
                'BandejasListachequeo.bandeja_id' => $bandejaId
                ),
            'recursive' => '-1'                
        ));
           
        return $arrListaBandeja;
    }

}
