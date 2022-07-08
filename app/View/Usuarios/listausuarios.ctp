<?php
    $this->layout='inicio';
?>

<div class="usuarios index">
        <legend><h2><?php echo __('Usuarios'); ?></h2></legend>
        <table class="table table-striped">
	<tr>
			<th><?php echo __('nombre'); ?></th>
                        <th><?php echo __('identificacion'); ?></th>
			
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($arrUsuarios as $usuario): ?>
	<tr>
		<td><?php echo h($usuario['Usuario']['nombre']); ?>&nbsp;</td>    
                <td><?php echo h($usuario['Usuario']['identificacion']); ?>&nbsp;</td> 
				<td><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('controller' => 'paquetesusuarios', 'action' => 'listasolicitudes', $usuario['Usuario']['id']), array('escape' => false)) ?></td>
	</tr>
<?php endforeach; ?>
	</table>

</div>
