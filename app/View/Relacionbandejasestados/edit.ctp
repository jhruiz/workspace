<?php $this->layout = 'inicio'; ?>
<div class="relacionbandejasestados form">
<?php echo $this->Form->create('Relacionbandejasestado'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Relación Bandeja - Estado'); ?></h2></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('bandeja_id');
		echo $this->Form->input('estado_id');
	?>
	</fieldset>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Relación Bandeja - Estados'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Bandejas'), array('controller' => 'bandejas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Bandeja'), array('controller' => 'bandejas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
	</ul>
</div>
