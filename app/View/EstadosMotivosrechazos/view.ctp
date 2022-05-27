<?php $this->layout = 'inicio'; ?>
<div class="estadosMotivosrechazos view">
<legend><h2><?php echo __('Estados Motivosrechazo'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo $this->Html->link($estadosMotivosrechazo['Estado']['descripcion'], array('controller' => 'estados', 'action' => 'view', $estadosMotivosrechazo['Estado']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Motivo de Rechazo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($estadosMotivosrechazo['Motivosrechazo']['descripcion'], array('controller' => 'motivosrechazos', 'action' => 'view', $estadosMotivosrechazo['Motivosrechazo']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Estado - Motivo de Rechazo'), array('action' => 'edit', $estadosMotivosrechazo['EstadosMotivosrechazo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Estados - Motivos de Rechazo'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado - Motivos de Rechazo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Motivos de Rechazo'), array('controller' => 'motivosrechazos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Motivo de Rechazo'), array('controller' => 'motivosrechazos', 'action' => 'add')); ?> </li>
	</ul>
</div>
