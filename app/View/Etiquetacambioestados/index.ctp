<?php $this->layout = 'inicio'; ?>
<div class="etiquetacambioestados index">
    
    
    <h2><?php echo __('Buscar Etiqueta Cambio Estados'); ?></h2> 
    <?php echo $this->Form->create('Etiquetacambioestado',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <legend><?php __('Etiquetacambioestado Search');?></legend>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Nombre'); ?>
                            </td>
                        </tr>
                    </table>
            <?php	echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior')); ?>
            </fieldset><br>
     <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
    </form>
    <br/>
    <br/>    
    
    
	<legend><h2><?php echo __('Etiquetas Cambio Estados'); ?></h2></legend>
        <table cellpadding="0" cellspacing="0" class="CSSTable">
	<tr>
			<th><?php echo ('Nombre'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($etiquetacambioestados as $etiquetacambioestado): ?>
	<tr>
		<td><?php echo h($etiquetacambioestado['Etiquetacambioestado']['descripcion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $etiquetacambioestado['Etiquetacambioestado']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $etiquetacambioestado['Etiquetacambioestado']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $etiquetacambioestado['Etiquetacambioestado']['id']), null, __('Está seguro que desea eliminar la etiqueta para cambio de estado %s?', $etiquetacambioestado['Etiquetacambioestado']['descripcion'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, mostrando {:current} registro de {:count} en total, iniciando en registro {:start}, finalizando en {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | | '));
		echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
    <legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Nueva Etiqueta Cambio Estado'), array('action' => 'add')); ?></li>
	</ul>
</div>
