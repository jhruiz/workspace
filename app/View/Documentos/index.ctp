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
			<th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('tipodocumento_id', 'Tipo Documental'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($documentos as $documento): ?>
	<tr>
		<td><?php echo h($documento['Documento']['descripcion']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($documento['Tipodocumento']['descripcion'], array('controller' => 'tipodocumentos', 'action' => 'view', $documento['Tipodocumento']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $documento['Documento']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $documento['Documento']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $documento['Documento']['id']), null, __('Esta seguro que quiere eliminar el documento:  # %s?', $documento['Documento']['descripcion'])); ?>
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
