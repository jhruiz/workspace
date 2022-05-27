<?php $this->layout = 'inicio'; ?>
<div class="menus view">
<legend><h2><?php echo __('Menú'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($menu[0]['Menu']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($menu[0]['Menu']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Menú Padre'); ?></dt>
		<dd>
			<?php echo h($menu[0]['Menu']['menu_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Menú'), array('action' => 'edit', $menu[0]['Menu']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Menús'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Menú'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Perfiles'), array('controller' => 'perfiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Perfil'), array('controller' => 'perfiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
