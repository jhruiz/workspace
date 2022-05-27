<?php    
    $this->layout = 'inicio'; 
?>
<div class="documentos view">
<legend><h2><?php echo __('Documento'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($documento['Documento']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Documento'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documento['Tipodocumento']['descripcion'], array('controller' => 'tipodocumentos', 'action' => 'view', $documento['Tipodocumento']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
    <legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Documento'), array('action' => 'edit', $documento['Documento']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Documentos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Documento'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Tipos Documentos'), array('controller' => 'tipodocumentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Tipo Documento'), array('controller' => 'tipodocumentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
