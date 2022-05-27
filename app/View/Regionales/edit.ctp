<?php $this->layout = 'inicio'; ?>
<div class="form">
<?php echo $this->Form->create('Regionale'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Regional'); ?></h2></legend>
                 <table>
                     <?php echo $this->Form->input('id',array('type'=>'hidden')); ?>
                    <tr>
                        <td colspan="3">
                            <?php echo $this->Form->input('descripcion',array('label' => "Nombre")); ?>                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php echo $this->Form->input('estadoregistro_id',array('label'=>'Estado')); ?>
                        </td>
                    </tr>
                 </table>	
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info')); ?>
    </form>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>

		
		<li><?php echo $this->Html->link(__('Lista Regionales'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Estado Registros'), array('controller' => 'estadoregistros', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado Registro'), array('controller' => 'estadoregistros', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('controller' => 'ciudades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Ciudad'), array('controller' => 'ciudades', 'action' => 'add')); ?> </li>
	</ul>
</div>
