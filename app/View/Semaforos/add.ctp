<?php echo $this->Html->css('colorpicker'); ?>
<?php echo $this->Html->script('colorpicker'); ?>
<?php echo $this->Html->script('semaforos/semaforos'); ?>
<?php $this->layout = 'inicio'; ?>

<div class="semaforos form">
<?php echo $this->Form->create('Semaforo'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Semáforo'); ?></h2></legend>
	<?php
		echo $this->Form->input('rangoinicial');
		echo $this->Form->input('rangofinal');
		echo $this->Form->input('color');
	?>
	</fieldset><br>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
