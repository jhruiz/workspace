<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('relacionBandejaEstados/relacionBandejaEstados.js');
?>
<div class="relacionbandejasestados index"><br>
    
        <div class="container">
            <div class="left">
                <h2><?php echo __('Relación Bandeja - Estados'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevaBandejaEstado()">Nueva Bandeja - Estado</button>
            </div>            
        </div>  

        <table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('bandeja_id'); ?></th>
			<th><?php echo $this->Paginator->sort('estado_id'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($relacionbandejasestados as $relacionbandejasestado): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($relacionbandejasestado['Bandeja']['descripcion'], array('controller' => 'bandejas', 'action' => 'view', $relacionbandejasestado['Bandeja']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($relacionbandejasestado['Estado']['descripcion'], array('controller' => 'estados', 'action' => 'view', $relacionbandejasestado['Estado']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $relacionbandejasestado['Relacionbandejasestado']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $relacionbandejasestado['Relacionbandejasestado']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $relacionbandejasestado['Relacionbandejasestado']['id']), null, __('Está seguro que desea eliminar la relación?')); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | | '));
		echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
