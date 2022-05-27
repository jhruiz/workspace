<?php $this->layout = 'inicio'; ?>
<div class="ciudades view">
    <legend><h2><?php echo __('Ciudades'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($ciudade['Ciudade']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Regional'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ciudade['Regionale']['descripcion'], array('controller' => 'regionales', 'action' => 'view', $ciudade['Regionale']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($ciudade['Estadoregistro']['descripcion']); ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Ciudad'), array('action' => 'edit', $ciudade['Ciudade']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Ciudad'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Regionales'), array('controller' => 'regionales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Regional'), array('controller' => 'regionales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Oficinas'), array('controller' => 'oficina', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Oficina'), array('controller' => 'oficina', 'action' => 'add')); ?> </li>
	</ul>
</div>