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
			<th><?php echo ('Nombre'); ?></th>
			<th><?php echo ('Url'); ?></th>
			<th><?php echo ('Menu Padre'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($menus as $menu): ?>
	<tr>
		<td><?php echo h($menu['Menu']['descripcion']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['url']); ?>&nbsp;</td>
		<td><?php echo h($menu['Menu']['menu_id']); ?>&nbsp;</td>
        <td class="actions">
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $menu['Menu']['id']), array('escape' => false)) ?>
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $menu['Menu']['id']),
                                            array('escape'=>false), __('Está seguro que desea eliminar el Menú: %s?', $menu['Menu']['descripcion']), array('class' => 'btn btn-mini')); ?>
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
