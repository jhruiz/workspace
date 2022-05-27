<?php $this->layout = 'inicio'; ?>
<div class="estados form">
<?php echo $this->Form->create('Estado'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Estado'); ?></h2></legend>

                <table>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('id',array('type'=>'hidden')); ?>
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
                            Permite Traslado
                        </td>
                    </tr>                     
                </table> 
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Bandejas'), array('controller' => 'bandejas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Bandeja'), array('controller' => 'bandejas', 'action' => 'add')); ?> </li>
	</ul>
</div>
