<?php $this->layout = 'inicio'; ?>
<div class="relacionbandejasestados view">
<legend><h2><?php echo __('Relación Bandeja - Estado'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Bandeja'); ?></dt>
		<dd>
			<?php echo $this->Html->link($relacionbandejasestado['Bandeja']['descripcion'], array('controller' => 'bandejas', 'action' => 'view', $relacionbandejasestado['Bandeja']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo $this->Html->link($relacionbandejasestado['Estado']['descripcion'], array('controller' => 'estados', 'action' => 'view', $relacionbandejasestado['Estado']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Relación Bandeja - Estado'), array('action' => 'edit', $relacionbandejasestado['Relacionbandejasestado']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Relación Bandeja - Estado'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Relación Bandeja Estado'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Bandejas'), array('controller' => 'bandejas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Bandeja'), array('controller' => 'bandejas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
	</ul>
</div>
