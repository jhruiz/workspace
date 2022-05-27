<?php $this->layout = 'inicio'; ?>
<div class="regionales view">
    <legend><h2><?php echo __('Regional'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($regionale['Regionale']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($regionale['Estadoregistro']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Regional'), array('action' => 'edit', $regionale['Regionale']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Regionales'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Regional'), array('action' => 'add')); ?> </li>				
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('controller' => 'ciudades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Ciudad'), array('controller' => 'ciudades', 'action' => 'add')); ?> </li>
	</ul>
</div>
