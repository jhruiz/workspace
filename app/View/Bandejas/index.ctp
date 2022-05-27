<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('bandeja/bandeja.js');
?>
<div class="bandejas index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2>
    <?php echo $this->Form->create('Bandeja',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Nombre'); ?>
                            </td>
                            <td>&nbsp;</td>
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
                <h2><?php echo __('Bandejas'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevaBandeja()">Nueva Bandeja</button>
            </div>
        </div> 

	<table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($bandejas as $bandeja): ?>
	<tr>
		<td><?php echo h($bandeja['Bandeja']['descripcion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $bandeja['Bandeja']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $bandeja['Bandeja']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $bandeja['Bandeja']['id']), null, __('Está seguro que desea eliminar la bandeja: %s?', $bandeja['Bandeja']['descripcion'])); ?>
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
