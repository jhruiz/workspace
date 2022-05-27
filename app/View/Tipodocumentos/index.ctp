<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('tiposdocumentales/tiposdocumentales.js');
?>
<div class="tipodocumentos index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2> 
    <?php echo $this->Form->create('Tipodocumento',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Nombre'); ?>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <?php echo $this->Form->input('Search.codigo'); ?>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>                                
                                <?php  echo $this->Form->input('Search.serie_id',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Tipo',
                                            'options' => $listSerie,
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
            <h2><?php echo __('Tipos Documentos'); ?></h2>
        </div>
        <div class="right">
            <button type="button" class="btn btn-primary" onclick="nuevoTipoDoc()">Nuevo Tipo Documental</button>
        </div>
    </div>      
    <table class="table table-striped">
    <tr>
                    <th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
                    <th><?php echo $this->Paginator->sort('codigo', 'Código'); ?></th>
                    <th><?php echo $this->Paginator->sort('serie_id'); ?></th>
                    <th class="actions"><?php echo __('Acciones'); ?></th>
    </tr>
    <?php foreach ($tipodocumentos as $tipodocumento): ?>
    <tr>
            <td><?php echo h($tipodocumento['Tipodocumento']['descripcion']); ?>&nbsp;</td>
            <td><?php echo h($tipodocumento['Tipodocumento']['codigo']); ?>&nbsp;</td>
            <td>
                    <?php echo $this->Html->link($tipodocumento['Serie']['descripcion'], array('controller' => 'series', 'action' => 'view', $tipodocumento['Serie']['id'])); ?>
            </td>
            <td class="actions">
                    <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $tipodocumento['Tipodocumento']['id'])); ?>
                    <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $tipodocumento['Tipodocumento']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $tipodocumento['Tipodocumento']['id']), null, __('Está seguro que desea eliminar el tipo documental # %s?', $tipodocumento['Tipodocumento']['descripcion'])); ?>
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
