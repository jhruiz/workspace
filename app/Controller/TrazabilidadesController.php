<?php

App::uses('AppController', 'Controller');
App::uses('BandejasController', 'Controller');

/**
 * Trazabilidades Controller
 *
 * @property Trazabilidade $Trazabilidade
 */
class TrazabilidadesController extends AppController {

    public function mostrarTrazabilidad() {
        if ($this->request->is('post')) {
            $this->loadModel('Estado');
            $bandejasController = new BandejasController();
            
            $paquete_id = $this->request->data("paquete_id");
            $nombre_bandeja = $this->request->data("nombre_bandeja");

            //Se obtienen los estados tipo finalizado
            $estadoFin = $this->Estado->obtenerEstadosFin();

            $arrEstF = array();
            $tiempoTotal = 0;
            foreach ($estadoFin as $estfin){
                $arrEstF[] = $estfin['Estado']['id'];
            }

            if (!empty($paquete_id)) {
                $trazas = $this->Trazabilidade->consultarTrazasPorPaqueteId($paquete_id);

                for($i = 0; $i < count($trazas); $i++){
                    if(!in_array($trazas[$i]['Estadodestino']['id'], $arrEstF)){
                        
                        $tiempoTotal =  $tiempoTotal + $trazas[$i]['Trazabilidade']['diaspromedio']; 
                        
                        if(is_null($trazas[$i]['Trazabilidade']['diaspromedio'])){
                            $diasEspera = $bandejasController->calcularDiasPaqueteEnEspera($trazas[$i]['Trazabilidade']['paquete_id']);
                            $trazas[$i]['Trazabilidade']['diaspromedio'] = $diasEspera; 
                            $tiempoTotal = $tiempoTotal + $diasEspera;
                        }
                    }else{
                        $tiempoTotal = $this->diasCierrePaquete($trazas[$i]['Paquete']['fechacreacion'], $trazas[$i]['Trazabilidade']['created']);
                    }                     
                }
                $this->set(compact('paquete_id', 'nombre_bandeja', 'trazas', 'tiempoTotal'));
            }
        }
    }
    
    
    
    /**
     * Funcion llamada via ajax que permite obtener la primer trazabilidad registrada para un paquete, 
     * dado su paquete_id
     * 
     * @return type
     */
    public function obtenerPrimerTrazabilidadPaqAjax(){
        
        $this->layout="ajax";
        $this->autoRender=false;
        $response=array();
        $response['estado']=false;
        
        if($this->request->is("post")){
            $paquete_id=$this->request->data("paquete_id");
            
            if(!empty($paquete_id)){
                $primeraTraza=$this->Trazabilidade->consultarPrimeraTrazaPaquete($paquete_id);
                
                if(!empty($primeraTraza)){
                    $response['estado']=true;
                    $response['datos']=$primeraTraza;
                }                                
            }
        }
        
        return json_encode($response);
    }
	
    public function diasCierrePaquete($fechaPaquete, $fechaTraza){
        $this->loadModel('Diasfestivo');
        $fechaAnterior = strtotime(h($fechaPaquete));
        $dias = floor(abs((strtotime($fechaTraza)-$fechaAnterior)/86400));
        $diasFestivos = $this->Diasfestivo->obtenerDiasFestivos($fechaPaquete, $fechaTraza);
        $diasTotal = ($dias) - $diasFestivos;
        return $diasTotal;          
    }	
    

}
