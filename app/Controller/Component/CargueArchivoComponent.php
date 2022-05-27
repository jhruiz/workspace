<?php

App::uses('Component', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargueArchivoComponent
 *
 * @author Datecsa
 */
class CargueArchivoComponent extends Component {
    //put your code here
    
    
    public function generarArchivoDJVU($urlDJvu, $urlArchivoOrigen, $urlDestinoDJVU ){        

//        $salida = shell_exec('"'.$urlDJvu.'\cjb2" -lossless "' . $urlArchivoOrigen . '" "' . $urlDestinoDJVU . '"');       
        $salida = shell_exec('"'.$urlDJvu.'\pdf2djvu\pdf2djvu" -o "' . $urlDestinoDJVU . '" "' . $urlArchivoOrigen. '"');               
    }
    
    /*
     * Funcion que permite subir un archivo al servidor y generar el archivo djvu

     * @param type $nombArchivoDestino: Nombre con el cual se almacenara el archivo
     * @param type $urlArchivoOrigen:  Url de donde se obtiene el archivo a subir
     * @param type $urlDestino : Url donde se almacenara el archivo en el servidor
     * @param type $urlDJVU :  Url de DJvuLibre en el servidor
     * @return boolean   Retorna true si se carga el archivo correctamente, false si ocurren errores  */
    public function subirArchivoWebRoot($nombArchivoDestino, $urlArchivoOrigen, $urlDestino, $urlDJVU) {
        
        $pdf = new FPDI();
        $archivo = new File($urlArchivoOrigen);
        $path_parts = pathinfo($nombArchivoDestino);
        $ext = $path_parts['extension'];

        //Se valida la extension del archivo pdf
        if (strtoupper($ext) != 'PDF' ) {
            
            $this->Session->setFlash(__('El archivo debe estar en formato PDF'));
            return false;
            
        } else {
            //Crear la carpeta destino en caso que no exista
            $carpetaDocumentos=$urlDestino;
            if (!file_exists($carpetaDocumentos)) {
                mkdir($carpetaDocumentos, 0777, true);
            } 
            
            ///Se carga el archivo en la carpeta destino
            $data = $archivo->read();
            $archivo->close();
            $archivo = new File($urlDestino ."/". $nombArchivoDestino, true);
            
            ///Si se carga correctamente el archivo, se genera el archivo djvu
            if ($archivo->write($data)) {
                
                $nameNExt = "\\" . str_replace('.PDF', '', strtoupper($nombArchivoDestino)) . ".djvu";
                $this->generarArchivoDJVU($urlDJVU,$archivo->path,$archivo->Folder->path . $nameNExt);

                return true;
            }else{
                return false;
            }
        }
    }
    
    
    
    
    /*
     * Funcion que crea en un array cada uno de los niveles(Carpetas) que conforma la url del archivo a almacenar
     */
    public function armarURLArchivoRepositorio($nivelesOrganizacion,$flujo,$identificador,$serie,$subserie,$tipodoc){                       
        
        $nivelesUrl=array();
        
        if(!empty($nivelesOrganizacion) && !empty($flujo) && !empty($identificador) && !empty($serie) && !empty($tipodoc)){
            
            ///Se obtiene cada uno de los ids de niveles organizacionales para armar la ruta del archivo
            foreach($nivelesOrganizacion as $nivelOrganizacion){
                $nivelesUrl[]=$nivelOrganizacion;
            }

            $nivelesUrl[]=$flujo;
            $nivelesUrl[]=$identificador;
            $nivelesUrl[]=$serie;
            
            ///Si se tiene una sub serie documental se le agrega un sufijo _ss
            if(!empty($subserie)){
                $nivelesUrl[]=$subserie."_ss";
            }
           
            $nivelesUrl[]=$tipodoc;              
        }
        
        return $nivelesUrl;
    }
    
    
    
    
    /*
     * Si no existe, crea cada una de las carpetas que contiene cada posicion del array, el item 
     * de la posicion 0 es la raiz y asi sucesivamente
     * 
     * @param $arrayUrlRepo: Array con cada una de las carpetas que se desean crear, las carpetas 
     * se crean dentro de la carpeta del repositorio del proyecto
     */
    public function crearCarpetasUrl($carpetaRaiz,$arrayUrlRepo){
        $urlCreadaResp=false;        
        $urlCreada="";
        
        if(!empty($carpetaRaiz) ){
            ////si no existe,se crea la carpeta del repositorio
            if (!file_exists($carpetaRaiz)) {
                $carpCreada=mkdir($carpetaRaiz, 0777, true);
                
                if($carpCreada){
                    $urlCreada=$carpetaRaiz;
                }
            }else{
                $urlCreada=$carpetaRaiz;
            }
            
            if(!empty($urlCreada)){   
                
                //Dentro de la carpeta del repositorio se crea las carpetas segun los items del array 
                foreach($arrayUrlRepo as $nivelUrl){

                    if (!file_exists($urlCreada."/".$nivelUrl)) {
                        $nivelCreado=mkdir($urlCreada."/".$nivelUrl, 0777, true);
                        if($nivelCreado){
                            $urlCreada.="/".$nivelUrl;
                            $urlCreadaResp=true;
                        }else{
                            $urlCreadaResp=false;
                            break;
                        }                  
                    }else{
                        $urlCreada.="/".$nivelUrl;
                        $urlCreadaResp=true;
                    }                    
                }
            }        
        }
        
        return $urlCreadaResp;
    }
    
    
    
    /**
     * Mueve el archivo de la carpeta tmp a la ruta que ingresa al metodo como parametro, el archivo queda nombrado segun $nombreArchivo
     * @param type $carpRaizRepoServer: url de tipo servidor de la carpeta raiz del servidor 
     * @param type $nombreTmp: Nombre del archivo a mover en la carpeta tmp
     * @param type $nuevaUrl: Url donde se va a enviar el archivo
     * @param type $extensionArchivo: Contiene la extension del archivo
     * @param type $remover: Indica si el archivo original se debe eliminar o no
     * @return type
     */
    public function enviarArchivoDeTmpAlRepo($carpRaizRepoServer,$nombreTmp,$nuevaUrl,$extensionArchivo,$remover){
        
        $archivoEnviadoResp=false;        
        $nombreArchivo=$nombreTmp.".".$extensionArchivo;
        
        if(!empty($nombreTmp) && !empty($nuevaUrl) && !empty($nombreArchivo)){
            
            ////Se obtienen las url de la carpeta tmp y la raiz del proyecto
//            $urlRaizTmp=$this->Configuraciondato->obtenerInfo('url_docstmp');
//            $urlRaizProyecto=$this->Configuraciondato->obtenerInfo('url_raizproyserver');
            
            if($remover){
                $archivoEnviado=rename($carpRaizRepoServer."/".$nombreArchivo,$nuevaUrl."/".$nombreArchivo);                        
                $archivoDJVUEnviado=rename($carpRaizRepoServer."/".$nombreTmp.".djvu",$nuevaUrl."/".$nombreTmp.".djvu");                                    
            }else{
                $archivoEnviado=copy($carpRaizRepoServer."/".$nombreArchivo,$nuevaUrl."/".$nombreArchivo);                        
                $archivoDJVUEnviado=copy($carpRaizRepoServer."/".$nombreTmp.".djvu",$nuevaUrl."/".$nombreTmp.".djvu");  
            }
            
            
            if($archivoEnviado && $archivoDJVUEnviado) 
                $archivoEnviadoResp=true;
        }
        
        return $archivoEnviadoResp;
    }
            
    
}
