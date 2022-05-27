<?php
    $this->layout='inicio';
?>
<div class="estadoregistros form">
<?php echo $this->Form->create('Estadoregistro'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Estado de registro'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
	?>
	</fieldset>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<br>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>

		<li><?php echo $this->Html->link(__('Lista Estado de registros'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Regionales'), array('controller' => 'regionales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Regional'), array('controller' => 'regionales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('controller' => 'ciudades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Ciudad'), array('controller' => 'ciudades', 'action' => 'add')); ?> </li>
	</ul>
</div>
