<div class="regionalesUsuarios view">
<h2><?php echo __('Regionales Usuario'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($regionalesUsuario['RegionalesUsuario']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Regionale'); ?></dt>
		<dd>
			<?php echo $this->Html->link($regionalesUsuario['Regionale']['descripcion'], array('controller' => 'regionales', 'action' => 'view', $regionalesUsuario['Regionale']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($regionalesUsuario['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $regionalesUsuario['Usuario']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Regionales Usuario'), array('action' => 'edit', $regionalesUsuario['RegionalesUsuario']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Regionales Usuario'), array('action' => 'delete', $regionalesUsuario['RegionalesUsuario']['id']), null, __('Are you sure you want to delete # %s?', $regionalesUsuario['RegionalesUsuario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Regionales Usuarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Regionales Usuario'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Regionales'), array('controller' => 'regionales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Regionale'), array('controller' => 'regionales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
