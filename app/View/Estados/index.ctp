<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('estados/estados.js');
?>
<div class="estados index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2>
    <?php echo $this->Form->create('Estado',array('action'=>'search','method'=>'post'));?>
            <fieldset>
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
    </div>
    <br/>
        <div class="container">
            <div class="left">
                <h2><?php echo __('Estados del Proceso'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoEstado()">Nuevo Estado</button>
            </div>
        </div>  
        <table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('estadoinicial', 'Estado Inicial'); ?></th>
			<th><?php echo $this->Paginator->sort('estadofinal', 'Estado Final'); ?></th>
			<th><?php echo $this->Paginator->sort('estadoanulado', 'Estado Anulado'); ?></th>
			<th><?php echo $this->Paginator->sort('adjuntararchivos', 'Adjuntar Archivos'); ?></th>
                        <th><?php echo $this->Paginator->sort('transferencia', 'Permite Transferencia'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($estados as $estado): ?>
	<tr>
		<td><?php echo h($estado['Estado']['descripcion']); ?>&nbsp;</td>
		<td><?php 
                        if($estado['Estado']['estadoinicial'] == '1'){
                            echo h('SI');
                        }else{
                            echo h('NO');
                        }
                    ?>&nbsp;
                </td>
		<td><?php 
                        if($estado['Estado']['estadofinal'] == '1'){
                            echo h('SI');
                        }else{
                            echo h('NO');
                        }                        
                    ?>&nbsp;
                </td>
		<td><?php 
                        if($estado['Estado']['estadoanulado'] == '1'){
                            echo h('SI');
                        }else{
                            echo h('NO');
                        }                        
                    ?>&nbsp;
                </td>
		<td><?php 
                        if($estado['Estado']['adjuntararchivos'] == '1'){
                            echo h('SI');
                        }else{
                            echo h('NO');
                        }                        
                    ?>&nbsp;
                </td>
		<td><?php 
                        if($estado['Estado']['trasladopaquete'] == '1'){
                            echo h('SI');
                        }else{
                            echo h('NO');
                        }                        
                    ?>&nbsp;
                </td>                
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $estado['Estado']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $estado['Estado']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $estado['Estado']['id']), null, __('Está seguro que desea eliminar el estado %s?', $estado['Estado']['descripcion'])); ?>
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
