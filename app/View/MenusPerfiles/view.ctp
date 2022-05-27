<?php $this->layout = 'inicio'; ?>
<div class="menusPerfiles view">
<legend><h2><?php echo __('Menú - Perfil'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Menú'); ?></dt>
		<dd>
			<?php echo $this->Html->link($menusPerfile['Menu']['descripcion'], array('controller' => 'menus', 'action' => 'view', $menusPerfile['Menu']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Perfil'); ?></dt>
		<dd>
			<?php echo $this->Html->link($menusPerfile['Perfile']['descripcion'], array('controller' => 'perfiles', 'action' => 'view', $menusPerfile['Perfile']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Menú - Perfil'), array('action' => 'edit', $menusPerfile['MenusPerfile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Menús - Perfiles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Menú - Perfil'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Menús'), array('controller' => 'menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Menú'), array('controller' => 'menus', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Perfiles'), array('controller' => 'perfiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Perfil'), array('controller' => 'perfiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
