<?php

App::uses('Component', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MestrosFijosComponent
 *Componente que tendran los metodos para obtener los ids de los maestros estaticos de la aplicacion
 * Ejemplo:  PermisoDocs, EstadoRegistro, PermisoBandeja
 * @author Datecsa
 */


class MaestrosfijosComponent extends Component{
    //put your code here
    
    ////Se obtienen algunos ids de los maestros necesarios para el funcionamiento de la aplicacion estos ids son usados por la aplicacion
    public function obtenerIdMaestrofijo($maestro){
        
        $idsMaestro=array();
        
        $tipoDocSolicitud=1;
        $tipoDocFactura=6;
        $tipoDocFacturaSello=8;
        $indicePadreDocMontoFactura=15;
        $indicePadreDocNumFactura=12;
        $bandejaflujoAprobFactCoord=6;
        $bandejaflujoAnalistaFinan=8;
        
        switch($maestro){
            case "bandejaflujoInicialTipoPaqFact": $idsMaestro=array(6);break;
            case "bandejaflujoAprobFactCoord": $idsMaestro=array($bandejaflujoAprobFactCoord);break;
            case "bandejaflujoAnalistaFinan": $idsMaestro=array($bandejaflujoAnalistaFinan);break;
            case "bandejaflujoAprobFactDir": $idsMaestro=array(13);break;
            case "bandejasflujoMostrarDistribuir": $idsMaestro=array($bandejaflujoAprobFactCoord,$bandejaflujoAnalistaFinan,14);break;
            case "tipoPaqueteSolicitud": $idsMaestro=array(1);break;
            case "tipoPaqueteFactura": $idsMaestro=array(2);break;
            case "indicePadreDocMontoFactura": $idsMaestro=array($indicePadreDocMontoFactura );break;
            case "indicePadreDocNumFactura": $idsMaestro=array($indicePadreDocNumFactura );break;
            case "flujosEspeciales": $idsMaestro=array(2); break;
            case "camposMostrarFacturas": $idsMaestro=array($indicePadreDocNumFactura,14,16,17,15); break;
            case "tipoDocSolicitud": $idsMaestro=array($tipoDocSolicitud); break;
            case "tipoDocFactura": $idsMaestro=array($tipoDocFactura); break;
            case "tipoDocFacturaSello": $idsMaestro=array($tipoDocFacturaSello); break;
            case "tipoDocComprobante": $idsMaestro=array(7); break;
            case "tipoDocOrdenCompra": $idsMaestro=array(5); break;
            case "perfilCoordinadorId": $idsMaestro=array(4); break;
            case "perfilDirectorId": $idsMaestro=array(5); break;
            case "indicesObtFacturaNovaTesor": $idsMaestro=array($indicePadreDocNumFactura,14,$indicePadreDocMontoFactura,17); break;
        }
        
        return $idsMaestro;
    }
    
    
    
    public function obtenerIdMaestroUnico($maestro){
        
        $valor=null;
        
        if(!empty($maestro)){
            $valor=$this->obtenerIdMaestrofijo($maestro);
        }
        
        return $valor[0];
    }
    
}
