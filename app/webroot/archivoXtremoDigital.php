<?php
//class archivoPlanoXtremoDigital{
  //      public function archivoPlanoXtremoDigital($idPaquete = null){
echo "pablo mariquita";
            $paquete = $_GET['idPaquete'];
            $paquete = $idPaquete;
            $this->loadModel('Paquete');
            $this->loadModel('Ciudade');
            ///Obtengo la informacion para armar la url donde estan los documentos
            $infoPaquete = $this->Paquete->find('all',array('conditions'=>array('Paquete.id'=>$paquete)));            
            $infoCiudad = $this->Ciudade->find('all',array('conditions'=>array('Ciudade.id'=>$infoPaquete[0]['Zona']['ciudade_id'])));
            $infoRegional=$infoCiudad[0]['Regionale'];
            $nuevo_num_admision=$infoPaquete[0]['Paquete']['num_admision_nuevo'];
            $identificacion_usu=$infoPaquete[0]['Paquete']['num_identificacion'];
            
            $url = WWW_ROOT."paquetes/".$infoRegional['codigo']."-".$infoRegional['nombre']."/".$infoCiudad[0]['Ciudade']['codigo']."-".$infoCiudad[0]['Ciudade']['nombre']."/".$infoPaquete[0]['Zona']['codigo']."-".$infoPaquete[0]['Zona']['descripcion']."/".$identificacion_usu."/".$nuevo_num_admision;
            
            $multiTIFF = new Imagick();
//            echo $url; die();
            $files = scandir($url);
            
            $infoArchivoXD=array();
            
            //Tipos documentales ya procesados
            $tipos_doc_procesados=array();
            
            $cant_archivos=0;
            $pag_inicio =1;
            //jaiber inicio
            ///Se recorren los archivos de la url            
            foreach ($files as $f){

                //Se obtiene la extension del archivo
                $nombre_extension=explode(".",$f);  
                if(empty($nombre_extension)){
                   continue; 
                }
                
                $extension=strtoupper($nombre_extension[count($nombre_extension)-1]);                                  
                                                
                //Obtengo solo los tiff, valido la extension de cada archivo en la carpeta
                if($extension=="TIF" || $extension=="TIFF"){
                    $cant_archivos++;                                       
                     ///Separo el numero de admision y el tipo documental del nombre del archivo
                    $nombre_archivo=explode("_",$f);                    
                    $tipo_doc[] = $nombre_archivo[0];
                    $anexosMultiTiff[] = $url."/".$f;                                      
                }                
            }
          
            for ($i=0;$i<count($anexosMultiTiff);$i++){
                $auxIMG = new Imagick();
                $auxIMG->setResolution(200,200);
                $auxIMG->readImage($anexosMultiTiff[$i]);  
                $multiTIFF->addImage($auxIMG);
            }
            
            //Se eliminan los tipos documentales repetidos
            $arrayKeysDocs = array_unique($tipo_doc);            
            //Se recorren los tipos documentales para obtener los datos que se plasmaran en el .txt
            for($i=0; $i<count($tipo_doc);$i++){                
                $arr_Datos = each($tipo_doc);
                for($j=1; $j<count($tipo_doc)-1;$j++){
                    if($tipo_doc[$j]==$tipo_doc[$j+1]){
                        //Se calcula la pagina inicial del tipo documental.
                        if(isset($arrayKeysDocs[$i]) && $tipo_doc[$j] == $arrayKeysDocs[$i]){
                            $pag_inicio = $i+1;
                        }
                        //Se obtiene la pagina donde terminal el tipo documental
                        $pag_fin = $arr_Datos['key']+1;
                        $infoArchivoXD[$tipo_doc[$i]]=array('tipo_doc' => $tipo_doc[$i],
                                                            'pag_ini' => $pag_inicio, 
                                                            'pag_fin'=>$pag_fin);                                                        
                    } 
                    else{  
                        continue;
                    }   
                }                
            }

            //jaiber fin            
            
            if($cant_archivos>0){
                ///Se le cambia la resolucion para que quede de 200 x 200 dpi
                $multiTIFF->setResolution(200,200); 

                //Se crea la carpeta que almacenara al multitiff
                mkdir($url."/".$nuevo_num_admision, 0777, true); 
                ///Se unen todas las imagenes en un multi tiff
                
                $multiTIFF->writeImages($url.'/'.$nuevo_num_admision.'/'.$nuevo_num_admision.'.TIFF', true);             
                //Se ingresa la url de la carpeta compartida donde se almacenaran los archivos generados para cargue de xtremo digital.
           
                ///Se crea el archivo para enviar al Xtremo Digital
                $nombArchivo=$url."/$nuevo_num_admision.txt";
                $archivo=  fopen($nombArchivo, "a");

              //Si no se pudo crear el archivo
                if(!$archivo){
                    $this->Session->setFlash('notice', 'No se pudo crear la lista de destinatarios para el envio.');
                }

                            $serie_doc_fija="517";
                            fputs($archivo,"$serie_doc_fija;133;1;FRA\n");

                //Se almacena en el archivo, la informacion necesaria.  
                foreach($infoArchivoXD as $tipos_doc => $datos){

                    fputs($archivo,"$nuevo_num_admision;$identificacion_usu|$nuevo_num_admision;".$datos['tipo_doc'].";".$datos['pag_ini'].";".$datos['pag_fin'].";;HC_COM\n");

                }
                fclose($archivo);
            }
  //      }
//}


?>