<?php $this->layout = 'inicio'; ?>
<div class="privilegiosUsuarios form">
<?php echo $this->Form->create('PrivilegiosUsuario'); ?>
	<fieldset>
		<legend><h2><?php echo __('Nuevo Privilegio - Usuario'); ?></h2></legend>
	<?php
		echo $this->Form->input('privilegio_id');
		echo $this->Form->input('usuario_id');
	?>
	</fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>