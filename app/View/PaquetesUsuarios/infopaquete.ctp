<?php
    $this->layout='inicio';
    
    echo $this->Html->script('utilsjs/utilArchivos.js');
    echo $this->Html->script('paquetes/infopaquete.js');
    echo $this->Html->script('trazabilidades/trazabilidad.js');

?>
<style type="text/css">
    #portapdf { 
        width: 1000px; 
        height: 800px; 
        border: 1px solid #484848; 
        margin: 0 auto; 
    }    
</style>
<div class="paquetes form" text-align: center>  
        <h2><?php echo __('Detalles'); ?></h2>
        <table class="table table-condensed">
            <tr>
                <td><b>Consecutivo:</b></td>    
                <td><?php echo $arrInfoPaquete['Paquete']['numerosolicitud']; ?></td>
                <td><b>Número:</b></td>
                <td><?php echo $arrInfoPaquete['Paquete']['numerocredencial'];?></td>
                <td><b>Fecha Creación:</b></td>
                <td><?php echo $arrInfoPaquete['Paquete']['fechacreacion']; ?></td>                 
            </tr>
            <tr>
                <td><b>Regional:</b></td>
                <td><?php echo $arrUbicacion['Regionale']['descripcion']; ?></td>
                <td><b>Ciudad:</b></td>
                <td><?php echo $arrUbicacion['Ciudade']['descripcion']; ?></td>
                <td><b>Oficina:</b></td>
                <td><?php echo $arrInfoPaquete['Oficina']['descripcion']; ?></td>                
            </tr>            
        </table>            
    <div>
        <legend><h2><?php echo __('Gestión'); ?></h2></legend>
        <table width='100%'>
             <tr>             
                 <?php  if(isset($permisoCambioUsr['PrivilegiosUsuario']) && $permisoCambioUsr['PrivilegiosUsuario']['privilegio_id'] == "4"){ ?>
                    <td><b>Usuario Encargado:</b> <?php if(isset($arrPaqUsr['Usuario'])){echo $arrPaqUsr['Usuario']['nombre'];} ?>
                        <?php  if($arrInfoPaquete['Estado']['trasladopaquete'] == "1"){ ?>   
                        &nbsp;&nbsp;&nbsp;&nbsp;<button id="butAsignarPaq" class="btn btn-info" onclick="cambiarUsuarioAsignado(<?php echo $arrInfoPaquete['Paquete']['id']; ?>,<?php echo $arrPaqUsr['PaquetesUsuario']['id']; ?>,<?php echo $arrPaqUsr['PaquetesUsuario']['usuario_id']; ?>)">Cambiar</button>
                        <?php } ?>
                    </td>
                    <td>&nbsp;</td>                    
                 <?php  }else{  ?>
                    <td colspan='2'><b>Usuario Encargado:</b> <?php echo $arrPaqUsr['Usuario']['nombre']; ?></td>      
                 <?php  }  ?>
                <td><b>Estado:</b></td>
                <td colspan="3"><?php echo $arrInfoPaquete['Estado']['descripcion']; ?>
                <?php  if(isset($permisoTraslado['PrivilegiosUsuario']) && $permisoTraslado['PrivilegiosUsuario']['privilegio_id'] == "3"){ ?>
                    <?php  if($arrInfoPaquete['Estado']['trasladopaquete'] == "1"){ ?>   
                        &nbsp;&nbsp;&nbsp;&nbsp;<button id="butCambiarBand" class="btn btn-info" onclick="cambiarEstadoOficio(<?php echo $arrInfoPaquete['Paquete']['id']; ?>,<?php echo $arrPaqUsr['PaquetesUsuario']['id']; ?>,<?php echo $usrLogin['id']; ?>,<?php echo $arrInfoPaquete['Estado']['id']?>)">Cambiar</button></td>               
                    <?php } ?>
                <?php } ?>                    
                    <td><button name="butVerTraza" id="butVerTraza" class="btn btn-info" onclick="mostrarTrazabilidad(<?php echo $arrInfoPaquete['Paquete']['id']; ?>,'<?php echo __($arrInfoPaquete['Estado']['descripcion']); ?>','div_trazabilidad');">Trazabilidad</button></td>
            </tr>
        </table>
    </div>
    <br>
    <fieldset>
        <legend><h4>Documento</h4></legend>
        
            <?php    
            if(count($documentosPaq)==0){
            ?>
            
            <div id="error" class="alert alert-success" style="text-align: center">
                <b>No hay documentos adjuntos para este paquete</b>
            </div>
                            
            <?php
            }else{
            ?>
                <div id="portapdf"> 
                    <object data="<?php echo $urlDocs . $documentosPaq['0']['Documentospaquete']['url_fisica']; ?>" type="application/pdf" width="100%" height="100%"></object> 
                </div>
            <?php    
            }                 
            ?>
                
    </fieldset>

    <br>

    <table width="100%">
        <tr>
            <td width="50%">
            <legend><h4>Observaciones:</h4></legend>
            <textarea name="obsGeneral" cols="300" rows="3" class="textAreaLoc" readonly id="obsGeneral"><?php if (isset($observacion['0'])){echo $observacion['0']['Observacione']['descripcion']; } ?></textarea>            
            </td>
        </tr>
    </table> 
    <br>
    <br>
    <br>
</div>
<div id="div_asignausuario"></div> 
<div id="div_cambiobandeja"></div>
<div id="div_trazabilidad"></div>