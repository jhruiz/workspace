<?php $this->layout = 'inicio'; ?>
<div class="regionalesUsuarios index">
	<h2><?php echo __('Regionales Usuarios'); ?></h2>
        <table cellpadding="0" cellspacing="0" class="CSSTable">
	<tr>
			<th><?php echo ('Regional'); ?></th>
			<th><?php echo ('Usuario'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($regionalesUsuarios as $regionalesUsuario): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($regionalesUsuario['Regionale']['descripcion'], array('controller' => 'regionales', 'action' => 'view', $regionalesUsuario['Regionale']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($regionalesUsuario['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $regionalesUsuario['Usuario']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $regionalesUsuario['RegionalesUsuario']['id']), null, __('Está seguro que desea eliminar la regional para el usuario?')); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, mostrando {:current} registro de {:count} en total, iniciando en registro {:start}, finalizando en {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | | '));
		echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Regionales'), array('controller' => 'regionales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Regional'), array('controller' => 'regionales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
