<?php $this->layout = 'inicio'; ?>
<div class="series view">
    <legend><h2><?php echo __('Series'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($series['Series']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Código'); ?></dt>
		<dd>
			<?php echo h($series['Series']['codigo']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
    <legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Series'), array('action' => 'edit', $series['Series']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Series'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Serie'), array('action' => 'add')); ?> </li>
	</ul>
</div>
