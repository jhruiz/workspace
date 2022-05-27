<?php $this->layout = 'inicio'; ?>
<div class="motivosrechazos view">
    <legend><h2><?php echo __('Motivo de Rechazo'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($motivosrechazo['Motivosrechazo']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Motivo de Rechazo'), array('action' => 'edit', $motivosrechazo['Motivosrechazo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Motivos de Rechazo'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Motivo de Rechazo'), array('action' => 'add')); ?> </li>
	</ul>
</div>