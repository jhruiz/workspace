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
			<th><?php echo ('rangoinicial'); ?></th>
			<th><?php echo ('rangofinal'); ?></th>
			<th><?php echo ('color'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($semaforos as $semaforo): ?>
	<tr>
		<td><?php echo h($semaforo['Semaforo']['rangoinicial']); ?>&nbsp;</td>
		<td><?php echo h($semaforo['Semaforo']['rangofinal']); ?>&nbsp;</td>
		<td bgcolor="#<?php echo h($semaforo['Semaforo']['color']); ?>" ><?php echo "#".h($semaforo['Semaforo']['color']); ?>&nbsp;</td>
		<td class="actions">
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $semaforo['Semaforo']['id']), array('escape' => false)) ?>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $semaforo['Semaforo']['id']), array('escape' => false)) ?>
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $semaforo['Semaforo']['id']),
                                            array('escape'=>false), __('Está seguro de eliminar el semáforo?'), array('class' => 'btn btn-mini')); ?>
        
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
