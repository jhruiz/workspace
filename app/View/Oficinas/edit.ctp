<?php
    $this->layout='inicio';
?>
<div class="oficinas form">
<?php echo $this->Form->create('Oficina'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Oficina'); ?></h2></legend>
                <?php echo $this->Form->input('id',array('type'=>'hidden')); ?>
	<?php
		echo $this->Form->input('descripcion',array('label' => "Nombre"));
		echo $this->Form->input('ciudade_id',array('label' => 'Ciudad'));
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
    <legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Oficinas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('controller' => 'ciudades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Ciudad'), array('controller' => 'ciudades', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
