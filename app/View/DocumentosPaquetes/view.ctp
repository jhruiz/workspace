<div class="documentosPaquetes view">
<h2><?php echo __('Documentos Paquete'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($documentospaquete['Documentospaquete']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Documento'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documentospaquete['Documento']['descripcion'], array('controller' => 'documentos', 'action' => 'view', $documentospaquete['Documento']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paquete'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documentospaquete['Paquete']['id'], array('controller' => 'paquetes', 'action' => 'view', $documentospaquete['Paquete']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url Fisica'); ?></dt>
		<dd>
			<?php echo h($documentospaquete['Documentospaquete']['url_fisica']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Revisado'); ?></dt>
		<dd>
			<?php echo h($documentospaquete['Documentospaquete']['revisado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Documentos Paquete'), array('action' => 'edit', $documentospaquete['Documentospaquete']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Documentos Paquete'), array('action' => 'delete', $documentospaquete['Documentospaquete']['id']), null, __('Are you sure you want to delete # %s?', $documentospaquete['Documentospaquete']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Documentos Paquetes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documentos Paquete'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Paquetes'), array('controller' => 'paquetes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paquete'), array('controller' => 'paquetes', 'action' => 'add')); ?> </li>
	</ul>
</div>
