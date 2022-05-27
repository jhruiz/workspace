<?php 
    $this->layout = 'inicio'; 
?>
<div class="tipodocumentos view">
<legend><h2><?php echo __('Tipo Documento'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($tipodocumento['Tipodocumento']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Código'); ?></dt>
		<dd>
			<?php echo h($tipodocumento['Tipodocumento']['codigo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Serie'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tipodocumento['Serie']['descripcion'], array('controller' => 'series', 'action' => 'view', $tipodocumento['Serie']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Tipo Documento'), array('action' => 'edit', $tipodocumento['Tipodocumento']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Tipo Documentos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Tipo Documento'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Series'), array('controller' => 'series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Serie'), array('controller' => 'series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
