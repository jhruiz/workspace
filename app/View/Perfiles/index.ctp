<?php
    $this->layout='inicio';
    echo $this->Html->script('perfil/perfil.js');
?>
<div class="form">
    <div id="acordion1">
	<h2><?php echo __('Filtros'); ?></h2>
        <?php echo $this->Form->create('Perfile',array('action'=>'search'));?>
                <fieldset>
                <?php			
                        echo $this->Form->input('Search.Nombre', array('class' => "alfanumeric"));
                        echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior'));                       
                ?>
                </fieldset>
        <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
        </form>
    </div>
        <br/>
        <div class="container">
            <div class="left">
                <h2><?php echo __('Perfiles'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoPerfil()">Nuevo Perfil</button>
            </div>
        </div>        
         <?php 
            
            if(!empty($perfiles)){
                
        ?>
                <table class="table table-striped">
                <tr>
                    <th><?php echo $this->Paginator->sort('nombre'); ?></th>
                    <th class="actions"><?php echo __('Acciones'); ?></th>
                </tr>
                <?php foreach ($perfiles as $perfile): ?>
                <tr>
                    <td><?php echo h($perfile['Perfile']['descripcion']); ?>&nbsp;</td>
                    <td class="actions">
                            <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $perfile['Perfile']['id'])); ?>
                            <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $perfile['Perfile']['id'])); ?>
                            <?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $perfile['Perfile']['id']), null, __('Está seguro que desea eliminar el Perfil %s?', $perfile['Perfile']['descripcion'])); ?>
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
         <?php
        
        }else{
                echo "No hay perfiles registrados en el sistema.";
            }
        ?>
</div>
