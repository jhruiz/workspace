<?php $this->layout = 'inicio'; ?>
<div class="semaforos form">
<?php echo $this->Form->create('Series'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Series'); ?></h2></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden'));
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
		echo $this->Form->input('codigo', array('label' => 'Código'));
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Series'), array('action' => 'index')); ?></li>
	</ul>
</div>