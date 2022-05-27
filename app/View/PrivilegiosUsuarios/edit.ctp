<?php $this->layout = 'inicio'; ?>
<div class="privilegiosUsuarios form">
<?php echo $this->Form->create('PrivilegiosUsuario'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Privilegio - Usuario'); ?></h2></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('privilegio_id');
		echo $this->Form->input('usuario_id');
	?>
	</fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Privilegios - Usuarios'), array('action' => 'index')); ?></li>
	</ul>
</div>
