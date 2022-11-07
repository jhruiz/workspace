<?php 
$this->layout='inicio';
echo ($this->Html->script('bandeja/gestionBandejas.js'));      
echo ($this->Html->script('usuarios/usuarios.js'));   
echo ($this->Html->script('usuarios/gestionusuarios.js')); 
echo ($this->Html->script('paquetes/indexaciondocumentos.js'));    

?>
<div class="form">
    <?php echo $this->Form->create(null, array('type' => 'file', 'controller' => 'documentospaquetes','action'=>'carguearchivos')); ?> 
    <?php echo $this->Form->input('paquete_id',array('type' => 'hidden', 'value' => $paqueteId));?>
    <table align="center" width="100%">
        <tr>   
            <td>
             <legend align="center">Petición</legend>                             
            </td>
        </tr>
        <tr>
            <td>
               <?php echo $this->Form->input('numero_documento',array('label' => 'Numero:', 'onblur' => 'validarSolicitud()'));?>
           </td>
       </tr>
        <?php echo $this->Form->input('oficio_id',array('type' => 'hidden'));?> 

    </table> 
    <div id="formCargue" style="display:none">
        <table align="center" width="100%"> 
            <tr>
                <td>
                    <fieldset>
                        <legend align="center">Estados</legend>
                        <div id="selectEst" style="display:none">
                            <?php 
                            echo $this->Form->input('Estado.id',
                                    array(
                                        'type' => 'select',
                                        'label' => 'Estados:',
                                        'options' => $arrEstados
                                    )
                                );
                            ?>
                        </div>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td>                      
                    <fieldset>
                        <legend align="center">Ubicación</legend>
                        <div id="selectReg" style="display:none">
                                <?php
                                    echo $this->Form->input('Regionale.id',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Regionales:',
                                            'options'=>$arrRegionales,
                                            'onChange'=>'obtenerCiudades()',
                                            'format' => array('label','input', 'after', 'error')
                                        )
                                    );  
                                ?>  
                        </div>
                        <div id="inputReg" style="display:none">
                            Regional: <input type="text" id="regNombre" name="regNombre" value="" readonly>
                        </div>
                    </fieldset>
                </td>
            </tr>                    
            <tr>
                <td>
                    <div id="selectCiu" style="display:none">
                        <div id='divCiudades'></div>                        
                    </div>
                    <div id='inputCiu' style="display:none">
                        Ciudad: &nbsp;&nbsp;  <input type="text" id="ciuNombre" name="ciuNombre" value="" readonly>
                    </div>
                </td>                                
            </tr>
            <tr>
                <td>
                    <div id="selectOfi" style="display:none">
                        <div id='divOficinas'></div>
                    </div>
                    <div id="inputOfi" style="display:none">
                        Oficina: &nbsp;&nbsp;  <input type="text" id="ofiNombre" name="ofiNombre" value="" readonly>
                        <input type="hidden" id="oficinaId" name="oficinaId" value="">
                    </div>    
                </td>                                
            </tr>                                
            <tr>              
                <td>
                    <fieldset>
                        <legend align="center">Documentos</legend>
                        <a id="agregarCampo" class="btn btn-info" href="#">Agregar Campo</a><br><br>
                    </fieldset>                                        
                </td>
            </tr>
            <tr>                  
                <td>                                    
                    <div id="contenedor">
                        Tipo Documento: 
                        <select name='data[Bandejatipo][tipoDoc_1]' id="nombreDocumento">
                            <?php foreach ($arrDocumentos as $key => $val):?>
                                <option value='<?php echo $key; ?>'><?php echo $val; ?> </option>            
                            <?php endforeach;?>
                        </select>
                        <br>
                        <div class="added">
                            <input type="file" name="data[Bandeja][documento_1]" class="buttonC white" id="BandejaArchivo">
                        </div>
                    </div>                                              
                </td>                        
            </tr> 
            <br>
            <tr>              
                <td><br><br>
                    <div id="cargar" id="contenedor">
                        <?php  echo $this->Form->button("Cargar", array('id' => 'butCargarArchivo',  'type'=>'button','class'=>'btn btn-info', 'onclick' => 'cargarArchivos();')); ?>
                    </div>                            
                </td>
            </tr>
        </table>    
        
    </div>
    
    </form>
</div> 
<container id="cont_divSelOficio">
<div id="div_seleccionoficio"></div>   
<div id="div_trazabilidad"></div> 
</container>

