<div class="oficinasUsuarios view">
<h2><?php echo __('Oficinas Usuario'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($oficinasUsuario['OficinasUsuario']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Oficina'); ?></dt>
		<dd>
			<?php echo $this->Html->link($oficinasUsuario['Oficina']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $oficinasUsuario['Oficina']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($oficinasUsuario['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $oficinasUsuario['Usuario']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Oficinas Usuario'), array('action' => 'edit', $oficinasUsuario['OficinasUsuario']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Oficinas Usuario'), array('action' => 'delete', $oficinasUsuario['OficinasUsuario']['id']), null, __('Are you sure you want to delete # %s?', $oficinasUsuario['OficinasUsuario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Oficinas Usuarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oficinas Usuario'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Oficinas'), array('controller' => 'oficinas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oficina'), array('controller' => 'oficinas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
