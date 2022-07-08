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
			<th><?php echo ('Nombre'); ?></th>
			<th><?php echo ('Código'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($series as $series): ?>
	<tr>
		<td><?php echo h($series['Series']['descripcion']); ?>&nbsp;</td>
		<td><?php echo h($series['Series']['codigo']); ?>&nbsp;</td>
		<td class="actions">
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $series['Series']['id']), array('escape' => false)) ?>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $series['Series']['id']), array('escape' => false)) ?>
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $series['Series']['id']),
                                            array('escape'=>false), __('Esta seguro que desea eliminar la serie %s?', $series['Series']['descripcion']), array('class' => 'btn btn-mini')); ?>
        
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
