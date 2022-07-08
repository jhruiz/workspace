<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('retencionesseries/retencionesseries.js');
?>
    <br/>
    
        <div class="container">
            <div class="left">
                <h2><?php echo __('Retención documental'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="addRetencion()">Nueva Retención Documental</button>
            </div>            
        </div>     

        <table class="table table-striped">
	<tr>
			<th><?php echo ('Serie'); ?></th>
			<th><?php echo ('Cantidad'); ?></th>
			<th><?php echo ('Unidad de Medida'); ?></th>
			<th><?php echo ('Acción'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php 
    foreach ($retencionesseries as $dr): ?>
	<tr>
		<td><?php echo h($series[$dr['RetencionesSeries']['serie_id']]); ?>&nbsp;</td>
		<td><?php echo h($dr['RetencionesSeries']['cantidad']); ?>&nbsp;</td>
		<td><?php echo h($uMed[$dr['RetencionesSeries']['unidadesmedida_id']]); ?>&nbsp;</td>
		<td><?php echo h($acciones[$dr['RetencionesSeries']['acciondisposicione_id']]); ?>&nbsp;</td>
		<td class="actions">
            <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'edit', $dr['RetencionesSeries']['id']), array('escape' => false)) ?>
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
