<?php $this->layout = 'inicio'; ?>
<div class="oficinasUsuarios index">
    <legend><h2><?php echo __('Relación Oficinas-Usuarios '); ?></h2></legend>
	<table class="table table-striped">
	<tr>
                        <th>Regional</th>
                        <th>Ciudad</th>
			<th>Oficina</th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($arrOficinasUsuarios as $oficinasUsuario): ?>        

      
	<tr>
		<td>
			<?php echo __($oficinasUsuario['REG']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $oficinasUsuario['OficinasUsuario']['oficina_id'])); ?>
		</td>
		<td>
			<?php echo __($oficinasUsuario['CIU']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $oficinasUsuario['OficinasUsuario']['oficina_id'])); ?>
		</td>                
		<td>
			<?php echo $this->Html->link($oficinasUsuario['OFI']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $oficinasUsuario['OficinasUsuario']['oficina_id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $oficinasUsuario['OficinasUsuario']['id']), null, __('Está seguro que desea eliminar la oficina para el usuario?')); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
