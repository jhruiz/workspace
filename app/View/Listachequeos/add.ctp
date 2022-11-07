<?php $this->layout = 'inicio'; ?>
<div class="listachequeos form">
<?php echo $this->Form->create('Listachequeo'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Item'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion', array('label' => 'Descripción'));
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
