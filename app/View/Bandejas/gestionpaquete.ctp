<?php

    $this->layout='inicio';
    echo $this->Html->script('utilsjs/utilsElementosHTML.js');
    echo $this->Html->script('utilsjs/utilArchivos.js');
    echo $this->Html->script('trazabilidades/trazabilidad.js');
    echo $this->Html->script('paquetes/gestionpaquete.js');
    echo $this->Html->script('bandeja/gestionBandejas.js');
    echo $this->Html->script('ubicaciones/ubicacionpaquete.js');
    echo $this->Html->script('documentos/documentos.js');
    echo $this->Html->script('paquetes/listachequeos.js');
    
?>
<style type="text/css">
    label {
        float: left;
        width: 30%;
        display: block;
        clear: left;
        text-align: left;
        cursor: hand;
    } 
    .textoSencillo {
        font-size: 14px;
        font-weight: normal;
        line-height: 15px;
    }
    .textAreaLoc {
        width: auto;
    }
    #portapdf { 
        width: 900px; 
        height: 800px; 
        border: 1px solid #484848; 
        margin: 0 auto; 
    }    
</style>

<div class="paquetes form" text-align: center>   

    <?php    
    echo $this->Form->create(null, array('id' =>'form_gestionar', 'url' => array('controller' => 'bandejas','action'=>'guardargestionpaquete')));
    
    if (isset($ultimaTraza['PaquetesUsuario']['Usuario']) && !empty($ultimaTraza['PaquetesUsuario']['Usuario']) )
        $usuarioPaqAsignadoAntes = $ultimaTraza['PaquetesUsuario']['Usuario']['id'];     
    ?>
    
    <input type="hidden" name="paqueteId" id="paqueteId" value='<?php echo $paqueteId; ?>' >
    <input type="hidden" name="bandejaActual" id="bandejaActual" value='<?php echo $estado; ?>' >   
    <input type="hidden" name="oficinaId" id="oficinaId" value='<?php echo $oficinaId; ?>' >   
    <input type="hidden" name="estadoId" id="estadoId" value='<?php echo $estadoId; ?>' > 
    <input type="hidden" name="bandejaId" id="bandejaId" value='<?php echo $bandejaId; ?>' > 
    <input type="hidden" name="numOficio" id="numOficio" value='<?php echo $numeroOficio; ?>' > 
    <input type="hidden" name="numCredencial" id="numCredencial" value='<?php echo $numeroCredencial; ?>' >     
    <textarea name="obsDevOfi" id="obsDevOfi" style="display:none;"></textarea>
    <input type="hidden" name="motivorechazo" id="motivorechazo" value=''> 
    <input type="hidden" name="urlDocs" id="urlDocs" value='<?php echo ($urlDocs); ?>'> 
    <div id="acordion1">
        <h4><?php echo __('Detalles'); ?></h4>
        <div>
        <table class="table table-condensed">
            <tr>
                <td><b>Solicitud:</b></td>
                <td><?php echo $numeroOficio; ?></td>
                <td><b>Credencial:</b></td>
                <?php if(isset($motivoPaquete['MotivosrechazosPaquete']) && $motivoPaquete['MotivosrechazosPaquete']['motivosrechazo_id'] == '7'){?>
                    <td><input type="text" name="numeroCredencial" id="numeroCredencial" value='<?php echo $numeroCredencial; ?>' onBlur='actualizarCredencial();'></td>
                <?php }else{?>
                    <td><?php echo $numeroCredencial; ?></td>
                <?php }?>                                
                <td><b>Estado:</b></td>
                <td><?php echo $estado; ?></td>                
            </tr>
            <tr>
                <td><b>Fecha Creación:</b></td>
                <td><?php echo $fechaCreacion; ?></td>
                <td><b>Oficina</b></td>
                <td><?php echo $nombreOficina; ?></td>
                <td><b>Usuario:</b></td>
                <?php if(isset($ultimaTraza['Usuario'])){?>
                <td><?php echo $ultimaTraza['Usuario']['nombre']; ?></td>                
                <?php } ?>
            </tr>
            <tr>
                <td colspan="6" id="trUbicacion"></td>
            </tr>
        </table>
        <button type="button" name="butVerTraza" id="butVerTraza" class="btn btn-info" onclick="mostrarTrazabilidad(<?php echo $paqueteId; ?>,'<?php echo __($estado); ?>','div_trazabilidad');">Trazabilidad</button>
        
        <?php if($infoEstado['Estado']['estadofinal'] == '1') { ?>
            <button type="button" id="butVerUbic" class="btn btn-info" onclick="mostrarUbicacion(<?php echo $paqueteId; ?>,'div_ubicacion');">Ubicación</button>
        <?php } ?>
        </div>
    </div>
    <br/>
    <br/>
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
                <div>
                    <select name="documentosPaquete" id="selDocPaq">
                        <?php foreach ($documentoGestion as $dosc) { ?>
                            <option data-dir="<?php echo($dosc['DocumentosPaquete']['url_fisica']); ?>" value="<?php echo ($dosc['DocumentosPaquete']['id']); ?>"><?php echo ($tipoDocs[$dosc['DocumentosPaquete']['documento_id']] . ' - ' . $dosc['DocumentosPaquete']['created']); ?></option> 
                        <?php } ?>
                    </select>
                    <br>
                    <?php  echo $this->Form->button("Eliminar", array('id' => 'btnEliminar', 'type'=>'button','class'=>'btn btn-danger', 'onclick' => 'eliminarDocumento();')); ?>
                    
                </div>

                <div id="portapdf"> 
                    <object data="<?php echo $urlDocs . $documentoGestion['0']['DocumentosPaquete']['url_fisica']; ?>" type="application/pdf" width="100%" height="100%"></object> 
                </div>

            <?php    
            }                 
            ?>

            <!--<br><button type="button" name="butCargueDoc" id="butCargueDoc" class="btn btn-info" onclick="cargarDocumentos(<?php //echo $paqueteId; ?>);">Cargar Documentos</button><br> -->
                
    </fieldset><br><br>

    <fieldset>
        <legend><h4>Lista de Checkeo</h4></legend>
        <?php foreach( $listaBandeja as $key => $val ) { ?>

            <?php $checked = ''; ?>
            <?php $checkedByUserDate = ''; ?>
            <?php if (isset($val['BandejasListachequeo']['user'])) {?>
                <?php $checkedByUserDate = $val['BandejasListachequeo']['user'] . ' (' . $val['BandejasListachequeo']['created_at'] . ')'; ?>
                <?php $checked = 'checked';?>
            <?php } ?>


            <div class="form-check">
                <input style="margin-top:0px;" class="form-check-input" type="checkbox" value="" id="<?php echo ($val['BandejasListachequeo']['bandeja_id'] . '_' . $val['LC']['id']); ?>" <?php echo $checked; ?> onchange="checkListBandeja(this);">
                <label class="form-check-label" for="flexCheckDefault">
                    <b><?php echo $val['LC']['descripcion']?></b>
                </label>

                <b id="userDate_<?php echo ($val['LC']['id']); ?>"><?php echo ($checkedByUserDate); ?></b>
                
            </div>

        <?php } ?>

    </fieldset>

    <table width="100%">
        <tr>
            <?php if(isset($permisobandejaId) && $permisobandejaId == 1){?>
            <td width="50%">
                <legend><h4>Agregar Observaci&oacute;n:</h4></legend>
                <textarea name="observacion" id="observacion" cols="60" rows="3" class="textAreaLoc" onblur="guardarObserv('<?php echo $datosUsuarioLogin['nombre']?>');"></textarea>
            </td>
            <?php } ?>
            <td width="50%">
                <legend><h4>Observaciones:</h4></legend>
                <textarea name="obsGeneral" cols="60" rows="3" class="textAreaLoc" readonly id="obsGeneral"><?php if (isset($observacion['0'])){echo $observacion['0']['Observacione']['descripcion']; } ?></textarea>            
            </td>
        </tr>
    </table>    
    <?php
        if(isset($listEstadosBandeja)){
            if(isset($permisobandejaId) && $permisobandejaId == 1){
    ?>
    <br>
    <br>
    <?php
        $attributes = array('id' => 'envioBandeja',  'class' => 'radio_bandSec',  'legend' => '<b>Enviar a: </b>', 'separator' => '<br/>', 'hiddenField' => false);
        echo $this->Form->radio('envioBandeja', $listEstadosBandeja, $attributes);         
    ?>
    <?php // echo $this->Form->input('estados', array('label' => "<B>GESTIONAR</b>", 'options' => $listEstadosBandeja, 'empty' => __('Seleccione Uno'))); ?>
        <br/>
        <br/>
        <button type="button" name="accion" id="enviar"  disabled="disabled" class='btn btn-info'> Guardar</button>       
    <?php 
            }
        }
    ?>
</form>
</div>
<div id="div_trazabilidad"></div>
<div id="div_ubicacion"></div>
<div id="div_obsDevOficio"></div>
