<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::import('Vendor', 'FPDI', array('file' => 'fpdi/fpdi.php'));
App::uses ('BandejasController', 'Controller');
require_once 'ConcatenarpdfController.php';
require_once 'EstadosController.php';
/**
 * Documentospaquetes Controller
 *
 * @property Documentospaquete $Documentospaquete
 * @property PaginatorComponent $Paginator
 */
class DocumentospaquetesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

        
        public function eliminardocpaqueteajax(){
            $this->layout="ajax";
            $this->autoRender=false;
            
            $response=array();
            $response['estado']=false;
            $response['docEliminado']=false;
            
            if($this->request->is("post")){
                $documentospaq_id=$this->request->data("documpaq_id");
                
                $docEliminado= $this->Documentospaquete->eliminarDocPaquete($documentospaq_id);
                $response['estado']=true;
                $response['docEliminado']=$docEliminado;
            }
            
            echo json_encode($response);
        }
        
        public function concatenarPDF($arrDocumentos, $nombreConcat){
            
            $pdf = new ConcatenarpdfController();
            $pdf->setFiles($arrDocumentos);
            $pdf->concat($nombreConcat);
            sleep(1);
        }
        
        public function carguearchivos($paqueteId = null){  
            $this->loadModel('Oficina');
            $this->loadModel('Regionale');
            $this->loadModel('Configuraciondato');
            $this->loadModel('Bandeja');
            $this->loadModel('Usuario');
            $this->loadModel('Paquete');
            $this->loadModel('Trazabilidade');
            $this->loadModel('PaquetesUsuario');
            $this->loadModel('Bandejasestado');
            $this->loadModel('Relacionbandejasestado');
            $this->loadModel('Auditoria');
            $this->loadModel('Estado');
            $BandejasController = new BandejasController;
            $EstadosController = new EstadosController();
            
            if($this->request->is('post')){                              
                $posData = $this->request->data;

                $numOficio = trim($posData['Documentospaquete']['numero_documento']);
                $oficioId = $posData['Documentospaquete']['oficio_id'];
                $oficinaId = $posData['oficinaId'];
                $tipoDoc = $posData['Bandeja']['tipoDoc_1'];
                $estadoInicialId = $posData['Estado']['id'];
                $cargueValido = TRUE;
                $mensaje = "";
                $arrUsuario = $this->Auth->user();

                //Se obtiene el id de la oficina
                if(!isset($posData['oficinaId']) || $posData['oficinaId'] == ""){
                    $oficinaId = $posData['Oficina']['Oficina'];
                }else{
                    $oficinaId = $posData['oficinaId'];
                }
                //Se obtiene la ubicacion del la oficina
                $arrUbicacion = $this->Oficina->obtenerUbicacionOficina($oficinaId);
                
                /*Se obtiene la url para los documentos*/
                $dato = 'dirPaquetes';
                $urlRaizDocs = $this->Configuraciondato->obtenerInfo($dato) . $arrUbicacion['C']['regionale_id'] . '\\' . $arrUbicacion['C']['id'] . '\\' . $oficinaId . '\\' . $numOficio;
                $urlDoc = $arrUbicacion['C']['regionale_id'] . '/' . $arrUbicacion['C']['id'] . '/' . $oficinaId . '/' . $numOficio . '/';

                //Se valida si la admision es nueva o existe en la aplicación
                if(isset($posData['Documentospaquete']['oficio_id']) && $posData['Documentospaquete']['oficio_id'] != ""){
                    /*Se obtiene la información completa del paquete*/
                    $arrPaquete = $this->Paquete->obtenerInfoPaquete($oficioId);
                    
                    /*Se el id del estado actual en que se encuentra el paquete*/
                    $estadoActAnulado = $arrPaquete['Estado']['estadoanulado'];
                    if($estadoActAnulado == '1'){
                        
                        /*Se obtiene la bandeja actual por el id del estado*/
                        $arrBandejaEstado = $this->Relacionbandejasestado->obtenerInfoRelacionBE($arrPaquete['Estado']['id']);
                        
                        /*Se obtiene el id del estado y el nombre del mismo al cual se debe enviar el paquete*/
                        $codNombreEstado = $this->Bandejasestado->obtenerEstadosPorBandeja($arrBandejaEstado['Relacionbandejasestado']['bandeja_id']);  

                        /*Se obtiene la información de la bandeja destino y del nuevo estado que tendrá el paquete*/
                        $nuevoEstadoId = $codNombreEstado['0']['Estado']['id'];
                        $arrBandejaDestino = $this->Relacionbandejasestado->obtenerInfoRelacionBE($nuevoEstadoId);
                        
                        //Se valida si el paquete ya ha sido gestionado por un usuario en el estado al que se desea enviar
                        $paqUsrId = $EstadosController->obtenerUltimoUsuarioGestionPaq($oficioId, $arrBandejaDestino['Relacionbandejasestado']['bandeja_id'], $oficinaId);

                        /*Se retira el paquete al usuario asignado*/
                        $BandejasController->retirarPaqueteUsuario($oficioId); 
                        
                        /*activar el paquete al usuario que lo gloso*/
                        $this->PaquetesUsuario->activarPaqueteUsuario($paqUsrId);
                        
                        /*Se realiza el registro del nuevo estado para el paquete y el numero de oficio*/
                        $this->Paquete->actualizarEstadoPaqueteAdmin($oficioId, $nuevoEstadoId);   
                        
                        /*Se registra en trazabilidad el cambio de estado*/
                        $BandejasController->guardarTrazabilidadOficio($arrPaquete['Paquete']['estado_id'], $nuevoEstadoId, $oficioId, $this->Auth->user('id'), $paqUsrId);           
                        
                        /*Se registra en auditoria el cambio de estado del paquete/oficio */
                        $accionAud = $this->Auditoria->accionAuditoria($mensajeId = '0');
                        $arrDescripcionAud['numOficio'] = $arrPaquete['Paquete']['numerocredencial'];
                        $arrDescripcionAud['estOrigen'] = $arrPaquete['Estado']['descripcion'];
                        $arrDescripcionAud['estDestino'] = $codNombreEstado['0']['Estado']['descripcion'];

                        $descripcionAud = $this->Auditoria->descripcionAuditoria($id = '0',$arrDescripcionAud);
                        $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud);                          
                    }
                    
                }else{               
                    
                    if(!empty($estadoInicialId)){
                        $estadoId = $estadoInicialId;
                        $arrInfoRelBandejaEst = $this->Relacionbandejasestado->obtenerInfoRelacionBE($estadoId);
                        $bandejaId = $arrInfoRelBandejaEst['Relacionbandejasestado']['bandeja_id'];
                    }else{
                        //se obtiene la bandeja a la cual se envia el paquete -- jaiber
                        $arrBandejaInicial = $this->Bandeja->obtenerBandejaInicial();
                        $bandejaId = $arrBandejaInicial['Bandeja']['id'];
                        $estadoId = $arrBandejaInicial['E']['id'];                        
                    }

                    //Se valida si existen usuarios con permisos de gestión sobre la bandeja y la oficina a la que se envia el paquete
                    $arrUsuarios = $this->Usuario->obtenerUsuarioGestionPaquete($oficinaId, $bandejaId, $usuario = null);
                    
                    if(count($arrUsuarios) > '0'){
                        //Se crea el paquete
                        $oficioId = $this->Paquete->crearPaquete($numOficio, $oficinaId, $estadoId);
                        
                        //Se crea el registro en paquetes usuario de quien lo crea.
                        $asignar = '0';
                        $this->PaquetesUsuario->asignarPaqueteUsuario($arrUsuario['id'], $oficioId, $asignar);
                        
                        //Se asigna por analisis de cargas el paquete
                        $paqUsrId = $BandejasController->asignacionAnalisisCargas($oficioId, $estadoId, $oficinaId);
                        
                        //Se guarda la trazabilidad del paquete nuevo
                        $this->Trazabilidade->guardarTrazabilidad($estadoId, $estadoId, $oficioId, $arrUsuario['id'], $paqUsrId);
                                                
                    }else{
                        $cargueValido = FALSE;
                        $mensaje .= "No se puedo realizar la creación ya que no hay usuario con permisos necesarios para asignar la solicitud";
                    }
                }
                
                /*Se elimina la posicion tipo documento del arreglo POST*/
                unset($posData['Bandeja']['tipoDoc_1']);
                if($cargueValido){
                    foreach($posData['Bandeja'] as $valor){
                        if (!$this->subirAarchivoWebRoot($valor, $urlRaizDocs, $oficioId, $numOficio, $tipoDoc, $urlDoc)) {
                            $cargueValido = FALSE;
                        }
                    }                       
                }
                
                if ($cargueValido) {                                        
                    $this->Session->setFlash(__('Se realizó la carga de forma correcta'));
                    return $this->redirect(array('action' => 'carguearchivos'));
                } else {
                    $this->Session->setFlash(__($mensaje));
                    return $this->redirect(array('action' => 'carguearchivos'));
                }
               
            }      
            $arrEstados = $this->Estado->obtenerEstadosIniciales();
            if(count($arrEstados) > 1){
                $arrEstados['0'] = 'SELECCIONE UNO';
                ksort($arrEstados);
            }            
            
            $arrDocumentos = $this->Documentospaquete->Documento->obtenerDocumentos();
            $arrRegionales = $this->Regionale->obtenerTodasRegionales();
            
            $this->set(compact('arrRegionales', 'arrDocumentos', 'paqueteId', 'arrEstados', 'emptyPos'));            
        }        
        
        public function subirAarchivoWebRoot($arrDocumento, $urlArchivo, $oficioId, $numOficio, $tipoDoc, $urlDoc){

            $this->loadModel('Auditoria');
            $pdf = new FPDI();
            $file = new File($arrDocumento['tmp_name']);
            $path_parts = pathinfo($arrDocumento['name']);
            $ext = $path_parts['extension'];
            $filename = "{$this->Auth->user('id')}_{$numOficio}_{$this->obtenerRestoNombreArchivo()}.{$ext}";
            $data = $file->read();
            $file->close();

            $file = new File($urlArchivo.'/'.$filename,true);

            if( $file->write($data)){
                /*Se registra documentospaquetes el documento para el paquete*/
                $idDocPaq = $this->Documentospaquete->guardarDocumentosPaquete($tipoDoc, $oficioId, $urlDoc . $filename);
                
                /*Se registra en auditoria el cargue del documento*/
                if(!is_null($idDocPaq)){
                    $id = '4';
                    $accion = $this->Auditoria->accionAuditoria($id);
                    $arrDescripcion['numOficio'] = $numOficio; 
                    $arrDescripcion['nomDocumento'] = $filename; 
                    $descripcion = $this->Auditoria->descripcionAuditoria($id, $arrDescripcion);
                    $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcion, $accion);
                }
                
                return TRUE;                    
            }else{

                return FALSE;
            }
        }
        
        
        public function obtenerRestoNombreArchivo(){
            $now = (string)microtime();
            $now = explode(' ', $now);
            $mm = explode('.', $now[0]);
            $mm = substr($mm[1], 0, 3);
            $now = $now[1];
            $segundos = $now % 60;
            $segundos = $segundos < 10 ? "$segundos" : $segundos;
            $nombre = strval(date("Ymd_Hi",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))) . "$segundos$mm");            
            
            return $nombre;
        }

        public function ajaxValidarSolicitud(){

                $this->loadModel('Privilegio');
                $this->loadModel('PrivilegiosUsuario'); 
                $this->loadModel('Paquete');
                $this->autoRender = false;             
                $usuario = $this->Auth->user();
                $credencial = trim($this->request->data['numeroDocumento']);
                $mensaje = "";
     
            //Se valida si el usuario tiene permisos para adjuntar documentos
                $permisoAdj = 'Adjuntar';
                $idPrivilegioAdj = $this->Privilegio->obtenerIdPrivilegio($permisoAdj);
                $arrPriviUsrAdj = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuario($usuario['id'], $idPrivilegioAdj);     

            //Se valida si el usuario tiene permisos para crear solicitudes
                $permisoDescC = 'Crear';
                $idPrivilegioC = $this->Privilegio->obtenerIdPrivilegio($permisoDescC);
                $arrPriviUsrC = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuario($usuario['id'], $idPrivilegioC);             
                
            //Si el usuario no tiene permisos para adjuntar documentos se retorna el respectivo mensaje
                if(count($arrPriviUsrAdj) <= 0){
                    $mensaje = "El usuario " . $usuario['nombre'] . " no tiene permisos para adjuntar documentos.";
                    $respuesta = (array('M' => $mensaje, 'S' => "", 'P' => ""));
                }else{        
                //Se busca la informacion de la solicitud ingresada por el usuario
                    $arrSolicitud = $this->Paquete->obtenerSolicitudesCargue($credencial, $usuario['id']);
                //Se valida si el usuario tiene permisos para crear y así mostrarle la opción de crear una solicitud nueva en el pop up
                    if(count($arrPriviUsrC) > 0){
                        $crear = $arrPriviUsrC['PrivilegiosUsuario']['privilegio_id'];
                    }else{
                        $crear = '0';
                    }     

                    //echo $crear;
                    //exit;
                //Si se encuentran solicitudes asignadas al usuario se muestra un pop up con la información de las mismas                
                    if(count($arrSolicitud) > 0 ){
                        $respuesta = (array('M' => "", 'S' => $arrSolicitud, 'P' => $crear));                    
                    }else if (count($arrSolicitud) <= 0 && $crear != '0'){
                        $respuesta = (array('M' => "", 'S' =>"", 'P' => $crear));
                    }else{
                        $mensaje = "El usaurio " . $usuario['nombre'] . " no tiene solicitudes relacionadas con éste número de credencial ni permisos para crear una nueva.";
                        $respuesta = (array('M' => $mensaje, 'S' => "", 'P' => ""));
                    }
                }
             $respuesta = (array('M' => "", 'S' => $arrSolicitud, 'P' => $crear)); 
                echo json_encode($respuesta);
                exit;
            }
            //Se consume el servicio web para obtener las credencial del usuarios.
           // $pageContents = HttpClient::quickGet('http://pruebas-sectorsalud.coomeva.com.co/saludmp-ws/jax-rs/saludmp-dgnet/DGNET_Credenciales/MCB/ABC123/CC/1143835898');

        public function mostrarProgramaCredenciales(){
            //Se obtienen los parametros enviados por post desde el ajax.
            $tipoDocumento = $this->request->data['tipoDocumento'];
            $numeroDocumento = $this->request->data['numeroDocumento'];
            $HttpSocket= new HttpSocket();
            //Se realiza la petición al servicio web que retorna las credenciales.
            $responseWS = $HttpSocket->get('http://pruebas-sectorsalud.coomeva.com.co/saludmp-ws/jax-rs/saludmp-dgnet/DGNET_Credenciales/MCB/ABC123/' . $tipoDocumento . '/' . $numeroDocumento);
            $response = json_decode($responseWS , true);
            $this->set(compact('response')); 
        }
    }
