<?php echo ($this->Html->script('usuarios/relacionoficinausuario.js')); ?> 
<?php
    $this->layout='inicio';
?>

<legend><h2><?php echo __('Oficinas Asociadas al Usuario: ' . $arrInfoUsuario['Usuario']['nombre']); ?></h2></legend>
	<table class="table table-striped">
	<tr>
                        <th>Regional</th>
                        <th>Ciudad</th>
			<th>Oficina</th>
	</tr>
	<?php foreach ($arrOficinasUsuarios as $oficinasUsuario): ?>        

      
	<tr>
		<td>
			<?php echo __($oficinasUsuario['REG']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $oficinasUsuario['OficinasUsuario']['oficina_id'])); ?>
		</td>
		<td>
			<?php echo __($oficinasUsuario['CIU']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $oficinasUsuario['OficinasUsuario']['oficina_id'])); ?>
		</td>                
		<td>
			<?php echo __($oficinasUsuario['OFI']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $oficinasUsuario['OficinasUsuario']['oficina_id'])); ?>
		</td>
	</tr>
        <?php endforeach; ?>
	</table><br><br>



<div class="form">
<?php echo $this->Form->create('Relacionar Zona Usuario'); ?>
	<fieldset>
		<legend><h2><?php echo __('Relacionar Zonas y Usuario'); ?></h2></legend>
            <table>               

                    <tr>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>                            
                        <td>                                                        
                            <?php
                                echo $this->Form->input('Regionale.id',
                                    array(
                                        'type' => 'select',
                                        'label' => 'Regionales',
                                        'options'=>$regionales,
                                        'onChange'=>'obtenerCiudades()',
                                    )
                                );  
                            ?>  
                            <div id="divCiudades">
                                <!--aqui se pinta el select de ciudades-->
                            </div>
                            <div id='divOficinas'>
                                <!--aqui se pinta el select de oficinas-->
                            </div>                            
                                 
                            
                        </td>                        
                    </tr>                     
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                           <?php echo $this->Form->submit('Registrar',array('class'=>'btn btn-info'));?>
                        </td>
                    </tr>
                
            </table>
	</fieldset>
    </form>
</div>

