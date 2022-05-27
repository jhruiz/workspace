<?php 
$this->layout = 'inicio';
echo $this->Html->script('ciudades/ciudades.js');
?>
<div>	
    <div id="acordion1">
        <h2><?php echo __('Filtros'); ?></h2>
        <?php echo $this->Form->create('Ciudade',array('action'=>'search'));?>
                <fieldset>                     
                        <table>
                            <tr>
                                <td>
                                    <?php  echo $this->Form->input('Search.Nombre',array('class' => "alfanumeric"));	?>
                                </td>
                                <td>&nbsp;&nbsp;</td>
                                <td>
                                    <?php echo $this->Form->input('Search.regionales', array('empty' => 'SELECCIONE UNO...')); ?>
                                </td>
                            </tr>
                        </table>   
                <?php	                       
                        echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'accion_anterior'));                       
                ?>
                </fieldset>
        <?php echo $this->Form->submit('Buscar',array('class'=>'btn btn-info'));?>
    </form>
    </div>
    <br>
    
        <div class="container">
            <div class="left">
                <h2><?php echo __('Ciudades'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevaCiudad()">Nueva Ciudad</button>
            </div>
        </div>      
        <?php             
            if(!empty($ciudades)){                
        ?>
        <table class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('descripcion', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('regionale_id','Regional'); ?></th>
			<th><?php echo $this->Paginator->sort('estadoregistro_id','Estado'); ?></th>	
			
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($ciudades as $ciudade): ?>
	<tr>
		<td><?php echo h($ciudade['Ciudade']['descripcion']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ciudade['Regionale']['descripcion'], array('controller' => 'regionales', 'action' => 'view', $ciudade['Regionale']['id'])); ?>
		</td>
		<td>
			<?php echo h($ciudade['Estadoregistro']['descripcion']); ?>
		</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $ciudade['Ciudade']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $ciudade['Ciudade']['id'])); ?>
                    <?php 
                                if($ciudade['Estadoregistro']['id']==1){
                                echo $this->Form->postLink(__('Inactivar'), array('action' => 'inactivar', $ciudade['Ciudade']['id']), null, __('Está seguro que desea inactivar la Ciudad %s?', $ciudade['Ciudade']['descripcion'])); 
                            }else{
                                echo $this->Form->postLink(__('Activar'), array('action' => 'inactivar', $ciudade['Ciudade']['id']), null, __('Está seguro que desea activar la Ciudad %s?', $ciudade['Ciudade']['descripcion']));                             
                            }
                        ?>
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
                echo "No hay ciudades registradas en el sistema.";
            }
        ?>
</div>
