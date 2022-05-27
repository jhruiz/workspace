<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('menu/menu.js');
?>
<div class="menus index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2> 
    <?php echo $this->Form->create('Menu',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <legend><?php __('Menu Search');?></legend>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Nombre'); ?>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td>                                
                                <?php  echo $this->Form->input('Search.menupadre_id',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Menu Padre',
                                            'options' => $listMenuPadre,
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
                <h2><?php echo __('Menús'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="addMenu()">Nuevo Menú</button>
            </div>            
        </div>     

        <table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th><?php echo $this->Paginator->sort('menu_id', 'Menu Padre'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($menus as $menu): ?>
	<tr>
		<td><?php echo h($menu['Menu']['descripcion']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['url']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['menu_id']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $menu['Menu']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $menu['Menu']['id']), null, __('Está seguro que desea eliminar el Menú: %s?', $menu['Menu']['descripcion'])); ?>
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
