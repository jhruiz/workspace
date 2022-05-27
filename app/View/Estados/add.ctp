<?php $this->layout = 'inicio'; ?>
<div class="estados form">
<?php echo $this->Form->create('Estado'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Estado'); ?></h2></legend>
                <table>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('descripcion', array('label' => 'Nombre')); ?><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->checkbox('estadoinicial'); ?>
                            Estado Inicial                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->checkbox('estadofinal'); ?>
                            Estado Final
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->checkbox('estadoanulado'); ?>
                            Estado Anulado
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->checkbox('adjuntararchivos'); ?>
                            Cargue Archivos
                        </td>
                    </tr>  
                    <tr>
                        <td>
                            <?php echo $this->Form->checkbox('trasladopaquete'); ?>
                            Permite Transferencia
                        </td>
                    </tr>                      
                </table>                    
	
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
