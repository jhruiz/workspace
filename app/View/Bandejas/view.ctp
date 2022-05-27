<?php $this->layout = 'inicio'; ?>
<div class="bandejas view">
<legend><h2><?php echo __('Bandeja'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($bandeja['Bandeja']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Bandeja'), array('action' => 'edit', $bandeja['Bandeja']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Bandejas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Bandeja'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Semáforos'), array('controller' => 'semaforos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Semáforo'), array('controller' => 'semaforos', 'action' => 'add')); ?> </li>
	</ul>
</div>