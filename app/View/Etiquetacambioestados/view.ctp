<?php $this->layout = 'inicio'; ?>
<div class="etiquetacambioestados view">
<legend><h2><?php echo __('Etiqueta Cambio Estado'); ?></h2></legend>
	<dl>

		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($etiquetacambioestado['Etiquetacambioestado']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Accciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Etiqueta Cambio Estado'), array('action' => 'edit', $etiquetacambioestado['Etiquetacambioestado']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Etiquetas Cambio Estados'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Etiqueta Cambio Estado'), array('action' => 'add')); ?> </li>
	</ul>
</div>