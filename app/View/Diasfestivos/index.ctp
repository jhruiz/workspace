<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('diasfestivos/diasfestivos.js');
?>
<div class="diasfestivos index">
    <br>
        <div class="container">
            <div class="left">
                <h2><?php echo __('Dias Festivos'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoDiaFestivo()">Nuevo Día Festivo</button>
            </div>
        </div>      
	<table class="table table-striped">
	<tr>
			<th><?php echo ('fecha'); ?></th>
			<th><?php echo ('descripcion'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($diasfestivos as $diasfestivo): ?>
	<tr>
		<td><?php echo h($diasfestivo['Diasfestivo']['fecha']); ?>&nbsp;</td>
		<td><?php echo h($diasfestivo['Diasfestivo']['descripcion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $diasfestivo['Diasfestivo']['id']), array('escape' => false)) ?>
			<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit',  $diasfestivo['Diasfestivo']['id']), array('escape' => false)) ?>
		
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $diasfestivo['Diasfestivo']['id']),
                                            array('escape'=>false), __('Está seguro que desea eliminar el día %s?', $diasfestivo['Diasfestivo']['descripcion']), array('class' => 'btn btn-mini')); ?>
        
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
