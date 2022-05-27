<?php
    $this->layout=false;    
    echo $this->Html->script('bandeja/formObservacionDevOfi.js');
?>

        <div class="paquetes form" id="divAsignaUsuario" text-align: center>   
            <center>
            <br/>
            <br/>
            <?php echo $this->Form->create(null, array('id' => 'formCambiarUsuPaq', 'default' => false)); ?>            
            <table width='100%'>
                <tr width="50%">
                    <td><center>
                        Motivos: 
                    </center></td>
                    <td><center>
                        <?php echo $this->Form->input('motivosrechazo', array('options' => $motivosRechazoList, 'id' => 'motivosrechazo', 'label' => false, 'empty' => 'SELECCIONE UNA: ', 'onchange' => 'agregarObservacion(this);')); ?>
                    </center></td>
                <tr>    
                <tr>
                    <td><center>
                        Observaciones: 
                    </center></td>
                    <td><center>
                        <textarea name="obsRechazo" id="obsRechazo" cols="60" rows="8" class="textAreaLoc">Fecha: <?php echo $fechaActual;?>.&#10;Usuario: <?php echo $nombreUsuario;?>&#13;&#10;Motivo: </textarea>
                    </center></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><center><button id="btn_rechazoOf" class="btn btn-info" >Guardar</button><br><br>            
                    <button id="btn_cancelarOf" class="btn btn-info" >Cancelar</button></center></td>
                </tr>
            </table> 
            </center>
        </form>
        </div>