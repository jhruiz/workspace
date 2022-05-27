<?php $this->layout = 'inicio'; ?>
<div class="menusPerfiles form">
<?php echo $this->Form->create('MenusPerfile'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Menú - Perfil'); ?></h2></legend>
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('menu_id', array('label' => 'Menú'));
		echo $this->Form->input('perfile_id');
	?>
	</fieldset><br>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Menús - Perfiles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Menús'), array('controller' => 'menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Menú'), array('controller' => 'menus', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Perfiles'), array('controller' => 'perfiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Perfil'), array('controller' => 'perfiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
