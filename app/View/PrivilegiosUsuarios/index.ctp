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
            <th><?php echo ('Privilegio'); ?></th>
            <th><?php echo ('Usuario'); ?></th>
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
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $privilegiosUsuario['PrivilegiosUsuario']['id']), array('escape' => false)) ?>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $privilegiosUsuario['PrivilegiosUsuario']['id']), array('escape' => false)) ?>
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $privilegiosUsuario['PrivilegiosUsuario']['id']),
                                            array('escape'=>false), __('Are you sure you want to delete # %s?', $privilegiosUsuario['PrivilegiosUsuario']['id']), array('class' => 'btn btn-mini')); ?>
        
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
