<?php
    $this->layout='inicio';
    echo $this->Html->script('usuarios/usuarios.js');
?>

<div class="usuarios index">
    <div id="acordion1">
    <h2><?php echo __('Filtros'); ?></h2> 
    <?php echo $this->Form->create('Usuario',array('action'=>'search','method'=>'post'));?>
            <fieldset>
                    <table>
                        <tr>
                            <td>
                                <?php echo $this->Form->input('Search.Nombre'); ?>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <?php echo $this->Form->input('Search.Login'); ?>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>                            
                            <td>                                
                                <?php  echo $this->Form->input('Search.perfile_id',
                                        array(
                                            'type' => 'select',
                                            'label' => 'Perfil',
                                            'options' => $listPerfile,
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
                <h2><?php echo __('Usuarios'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevoUsuario()">Nuevo Usuario</button>
            </div>
        </div>      
        <table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('username','Login'); ?></th>
			<th><?php echo $this->Paginator->sort('perfile_id','Perfil'); ?></th>
			<th><?php echo $this->Paginator->sort('correoelectronico'); ?></th>
                        <th><?php echo $this->Paginator->sort('identificacion'); ?></th>
			<th><?php echo $this->Paginator->sort('estadoregistro_id', 'Estado'); ?></th>
			
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($usuarios as $usuario): ?>
	<tr>
		<td><?php echo h($usuario['Usuario']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($usuario['Usuario']['username']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($usuario['Perfile']['descripcion'], array('controller' => 'perfiles', 'action' => 'view', $usuario['Perfile']['id'])); ?>
		</td>
		<td><?php echo h($usuario['Usuario']['correoelectronico']); ?>&nbsp;</td>
		<td><?php echo h($usuario['Usuario']['identificacion']); ?>&nbsp;</td>
		<td><?php echo h($usuario['Estadoregistro']['descripcion']); ?></td>                               
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $usuario['Usuario']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $usuario['Usuario']['id'])); ?>
                        <?php 
                            if($usuario['Estadoregistro']['id']==1){
                                echo $this->Form->postLink(__('Inactivar'), array('action' => 'inactivar', $usuario['Usuario']['id']), null, __('Está seguro que desea inactivar el Usuario %s?', $usuario['Usuario']['nombre'])); 
                            }else{
                                echo $this->Form->postLink(__('Activar'), array('action' => 'activar', $usuario['Usuario']['id']), null, __('Está seguro que desea activar el Usuario %s?', $usuario['Usuario']['nombre']));                             
                            }                            
                        ?> 
                        <?php echo $this->Html->link(__('Oficina+'), array('action'=>'relacionoficinausuario', $usuario['Usuario']['id'])); ?>
                        <?php echo $this->Html->link(__('Oficina-'), array('controller'=> 'OficinasUsuarios', 'action'=>'index', $usuario['Usuario']['id'])); ?>                    
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
