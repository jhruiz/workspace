<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('privilegioUsuario/privilegioUsuario.js');
?>

<div class="privilegiosUsuarios index"><br>
        <div class="container">
            <div class="left">
                <h2><?php echo __('Privilegios por Usuarios'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoPrivilegioUsuario()">Agregar Privilegio a Usuario</button>
            </div>
        </div>      
        <table class="table table-striped">
	<tr>
            <th><?php echo $this->Paginator->sort('privilegio_id'); ?></th>
            <th><?php echo $this->Paginator->sort('usuario_id'); ?></th>
            <th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($privilegiosUsuarios as $privilegiosUsuario): ?>
	<tr>
		<td>
			<?php echo ($privilegiosUsuario['Privilegio']['descripcion']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($privilegiosUsuario['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'view', $privilegiosUsuario['Usuario']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $privilegiosUsuario['PrivilegiosUsuario']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $privilegiosUsuario['PrivilegiosUsuario']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $privilegiosUsuario['PrivilegiosUsuario']['id']), null, __('Are you sure you want to delete # %s?', $privilegiosUsuario['PrivilegiosUsuario']['id'])); ?>
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
