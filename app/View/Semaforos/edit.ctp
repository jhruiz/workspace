<?php echo $this->Html->css('colorpicker'); ?>
<?php echo $this->Html->script('colorpicker'); ?>
<?php echo $this->Html->script('semaforos/semaforos'); ?>
<?php $this->layout = 'inicio'; ?>
<div class="semaforos form">
<?php echo $this->Form->create('Semaforo'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Semaforo'); ?></h2></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden'));
		echo $this->Form->input('rangoinicial');
		echo $this->Form->input('rangofinal');
		echo $this->Form->input('color');
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Semáforos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Bandejas'), array('controller' => 'bandejas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Bandeja'), array('controller' => 'bandejas', 'action' => 'add')); ?> </li>
	</ul>
</div>
