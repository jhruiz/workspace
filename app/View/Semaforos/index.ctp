<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('semaforos/semaforos.js');
?>
<div class="semaforos index"><br>
        <div class="container">
            <div class="left">
                <h2><?php echo __('Semáforos'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoSemaforo()">Nuevo Semáforo</button>
            </div>
        </div>      
        <table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('rangoinicial'); ?></th>
			<th><?php echo $this->Paginator->sort('rangofinal'); ?></th>
			<th><?php echo $this->Paginator->sort('color'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($semaforos as $semaforo): ?>
	<tr>
		<td><?php echo h($semaforo['Semaforo']['rangoinicial']); ?>&nbsp;</td>
		<td><?php echo h($semaforo['Semaforo']['rangofinal']); ?>&nbsp;</td>
		<td bgcolor="#<?php echo h($semaforo['Semaforo']['color']); ?>" ><?php echo "#".h($semaforo['Semaforo']['color']); ?>&nbsp;</td>
		<td class="actions">
                    <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $semaforo['Semaforo']['id'])); ?>
                    <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $semaforo['Semaforo']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $semaforo['Semaforo']['id']), null, __('Está seguro de eliminar el semáforo %s?', '')); ?>
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
