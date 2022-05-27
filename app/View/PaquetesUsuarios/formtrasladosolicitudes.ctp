<?php
    $this->layout=false;    
    echo $this->Html->script('paquetesusuarios/formtrasladosolicitudes.js');
?>

        <div class="paquetes form" id="divAsignaUsuario" text-align: center>   
            <center>
            <br/>
            <br/>
            <?php echo $this->Form->create(null, array('id' => 'formCambiarUsuPaq', 'default' => false)); ?>            
            <table>
                <tr>
                    <td><center>
                        Motivos de Traslado: 
                    </center></td><br>
                </tr>
                <tr>
                    <td><center>
                        <?php echo $this->Form->input('motivostraslado', array('options' => $arrMotivosTraslado, 'id' => 'motivostraslado', 'label' => false, 'empty' => 'SELECCIONE UNO: ')); ?>
                    </center></td>
                </tr>    
                <tr>                    
                    <td><center><button id="btn_trasladoOf" class="btn btn-info" >Trasladar</button><br><br>            
                    <button id="btn_cancelarTraslado" class="btn btn-info" >Cancelar</button></center></td>
                </tr>
            </table> 
            </center>
        </form>
        </div>