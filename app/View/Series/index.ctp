<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('serieDocs/seriedocumentales.js');
?>
<div class="series index"><br>
    <div class="container">
        <div class="left">
            <h2><?php echo __('Series'); ?></h2>
        </div>
        <div class="right">
            <button type="button" class="btn btn-primary" onclick="nuevaSerie()">Nueva Serie</button>
        </div>
    </div>      
        <table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('codigo', 'Código'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($series as $series): ?>
	<tr>
		<td><?php echo h($series['Series']['descripcion']); ?>&nbsp;</td>
		<td><?php echo h($series['Series']['codigo']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $series['Series']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $series['Series']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $series['Series']['id']), null, __('Esta seguro que desea eliminar la serie?', $series['Series']['descripcion'])); ?>
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
