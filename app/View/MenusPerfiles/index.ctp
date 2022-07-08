<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('menusPerfiles/menusPerfiles.js');
?>
<div class="menusPerfiles index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2>
    <?php echo $this->Form->create('Menusperfile',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <table>
                        <tr>
                            <td>                                
                                <?php  echo $this->Form->input('Search.menus',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Menus',
                                            'options' => $listMenus,
                                            'empty' => 'SELECCIONE UNO...'
                                        )
                                    );  
                                ?>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td>                                
                                <?php  echo $this->Form->input('Search.perfiles',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Perfiles',
                                            'options' => $listPerfiles,
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
                <h2><?php echo __('Menús - Perfiles'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoMenuPerfil()">Nuevo Menú - Perfil</button>
            </div>
        </div>      

        <table class="table table-striped">
	<tr>
            <th><?php echo ('Menú'); ?></th>
            <th><?php echo ('Perfil'); ?></th>
            <th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($menusPerfiles as $menusPerfile): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($menusPerfile['Menu']['descripcion'], array('controller' => 'menus', 'action' => 'view', $menusPerfile['Menu']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($menusPerfile['Perfile']['descripcion'], array('controller' => 'perfiles', 'action' => 'view', $menusPerfile['Perfile']['id'])); ?>
		</td>
        <td class="actions">
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $menusPerfile['MenusPerfile']['id']), array('escape' => false)) ?>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $menusPerfile['MenusPerfile']['id']), array('escape' => false)) ?>
			<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash fa-lg')). "", array('action' => 'delete', $menusPerfile['MenusPerfile']['id']),
                                            array('escape'=>false), __('Está seguro que desea eliminar la relación Menú - Perfil?'), array('class' => 'btn btn-mini')); ?>
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
