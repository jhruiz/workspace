<?php    
    $this->layout = 'inicio'; 
    echo $this->Html->script('documentos/documentos.js');
?>
<div class="documentos index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2> 
    <?php echo $this->Form->create('Documento',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Nombre'); ?>
                            </td>
                            <td>&nbsp;</td>
                            <td>                                
                                <?php  echo $this->Form->input('Search.tipodocumentale_id',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Tipo',
                                            'options' => $tipodocumental,
                                            'empty' => 'SELECCIONE UNO...'
                                        )
                                    );  
                                ?>
                            </td>
                        </tr>
                    </table>
            <?php	echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior')); ?>
            </fieldset><br>
     <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
    </form>
    </div>
    <br/>
    
        <div class="container">
            <div class="left">
                <h2><?php echo __('Documentos'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoDocumento()">Nuevo Documento</button>
            </div>
        </div>      
	<table class="table table-striped">
	<tr>
			<th><?php echo ('Nombre'); ?></th>
			<th><?php echo ('Tipo Documental'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($documentos as $documento): ?>
	<tr>
		<td><?php echo h($documento['Documento']['descripcion']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($documento['Tipodocumento']['descripcion'], array('controller' => 'tipodocumentos', 'action' => 'view', $documento['Tipodocumento']['id'])); ?>
		</td>
        <td class="actions">
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $documento['Documento']['id']), array('escape' => false)) ?>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $documento['Documento']['id']), array('escape' => false)) ?>
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $documento['Documento']['id']),
                                            array('escape'=>false), __('Esta seguro que quiere eliminar el documento:  %s?', $documento['Documento']['descripcion']), array('class' => 'btn btn-mini')); ?>
        
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
