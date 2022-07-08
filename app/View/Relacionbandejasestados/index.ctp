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
			<th><?php echo ('Bandeja'); ?></th>
			<th><?php echo ('Estado'); ?></th>
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
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $relacionbandejasestado['Relacionbandejasestado']['id']), array('escape' => false)) ?>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $relacionbandejasestado['Relacionbandejasestado']['id']), array('escape' => false)) ?>
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $relacionbandejasestado['Relacionbandejasestado']['id']),
                                            array('escape'=>false), __('Está seguro que desea eliminar la relación?'), array('class' => 'btn btn-mini')); ?>
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
