<?php
App::uses('AppModel', 'Model');
/**
 * Solicitudreporte Model
 *
 */
class Solicitudreporte extends AppModel {
    
    public function guardarSolicitudReporte($estadoActual = null,$tiporeporte = null,$fecha_inicio = null,
                                            $fecha_fin = null,$regional = null,$ciudad = null,
                                            $oficina = null, $auditor = null,  $ejecutivo = null,
                                            $usuarioSolicitud  = null){
            $data=array();                        
                
            $solicitudreporte=new Solicitudreporte();                        
            
            $data['tiporeporte']=$tiporeporte;
            $data['regional']=$regional;
            $data['ciudad']=$ciudad;
            $data['oficina']=$oficina;            
            $data['fechainicial']=$fecha_inicio;
            $data['fechafinal']=$fecha_fin;
            $data['usuarioauditor_id']=$auditor;
            $data['usuarioejecutivo_id']=$ejecutivo;
            $data['usuariosolicitud_id']=$usuarioSolicitud;
            $data['estado_id']=$estadoActual;
            $data['estadosolicitud']='1';
            
            if($solicitudreporte->save($data)){
                return true;
            }else{
                return false;
            }        
    }

}
