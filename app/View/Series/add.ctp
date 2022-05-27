<?php $this->layout = 'inicio'; ?>
<div class="series form">
<?php echo $this->Form->create('Series'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Serie'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
		echo $this->Form->input('codigo', array('label' => 'Código'));
	?>
	</fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
