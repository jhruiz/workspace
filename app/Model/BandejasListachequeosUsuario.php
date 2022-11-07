<?php
App::uses('AppModel', 'Model');

class BandejasListachequeosUsuario extends AppModel {

    /**
     * obtiene los items configurados para una bandeja
     */
    public function obtenerListasCheckeadasUsuario($bandejaId, $paqueteId){

        $arr_join = array();
        
        array_push($arr_join, array(
            'table' => 'usuarios',
            'alias' => 'U', 
            'type' => 'INNER',
            'conditions' => array(
                'U.id=BandejasListachequeosUsuario.usuario_id')
        ));
        
        $itemsBandUsr = $this->find('all', array(
            'joins' => $arr_join,   
            'fields' => array(
                'U.id',
                'U.nombre',
                'BandejasListachequeosUsuario.*'
            ),
            'conditions' => array(
                'BandejasListachequeosUsuario.bandeja_id' => $bandejaId,
                'BandejasListachequeosUsuario.paquete_id' => $paqueteId
                ),
            'recursive' => '-1'                
        ));

        return $itemsBandUsr;
    }

    /**
     * Agrega el check de la bandeja y el usuario
     */
    public function agregarItembandejaUsr($idBandeja, $idItem, $usuarioId, $date, $paqueteId){
        $data=array();                        
                
        $bandejaItemUsr = new BandejasListachequeosUsuario();                        
        
        $data['bandeja_id'] = $idBandeja;
        $data['listachequeo_id'] = $idItem;
        $data['usuario_id'] = $usuarioId;
        $data['paquete_id'] = $paqueteId;
        $data['created_at']= $date;
        
        if($bandejaItemUsr->save($data)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Elimina el check de la bandeja y el usuario
     */
    public function eliminarItembandejaUsr($idBandeja, $idItem, $usuarioId, $paqueteId){
        $condiciones=array(
            'BandejasListachequeosUsuario.bandeja_id' => $idBandeja, 
            'BandejasListachequeosUsuario.listachequeo_id' => $idItem,
            'BandejasListachequeosUsuario.usuario_id' => $usuarioId,
            'BandejasListachequeosUsuario.paquete_id' => $paqueteId
        );
        $resp = $this->deleteAll(array($condiciones),false);

        return $resp;
    }

}
