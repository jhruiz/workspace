<?php $this->layout = 'inicio'; ?>
<div class="relacionbandejasestados form">
<?php echo $this->Form->create('Relacionbandejasestado'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Relación Bandeja - Estado'); ?></h2></legend>
	<?php
		echo $this->Form->input('bandeja_id');
		echo $this->Form->input('estado_id');
	?>
	</fieldset>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
