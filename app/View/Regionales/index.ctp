<?php 
$this->layout = 'inicio'; 
echo $this->Html->script('regionales/regionales.js');
?>
<div>
    <div id="acordion1">
        <h2><?php echo __('Filtros'); ?></h2>
        <?php echo $this->Form->create( 'Regionale',array('action'=>'search'));?>
                <fieldset>                        
                        <table>
                            <tr>
                                <td>
                                    <?php  echo $this->Form->input('Search.Nombre');	?>
                                </td>
                            </tr>
                        </table>
                <?php			
                       echo $this->Form->input('accion_anterior', array('type'=>'hidden', 'value'=>'index', 'id'=>'action_anterior'));
                ?>
                </fieldset>
        <?php echo $this->Form->submit('Buscar',  array('class'=>'btn btn-info'));?>
         </form>
         </div>
        <br>
        <div class="container">
            <div class="left">
                <h2><?php echo __('Regionales'); ?></h2>
            </div>
            <div class="right">
                <button type="button" class="btn btn-primary" onclick="nuevaRegional()">Nueva Regional</button>
            </div>
        </div>
        <?php 
            
            if(!empty($regionales)){
                
        ?>
                <table class="table table-striped">
                <tr>
                                <th><?php echo ('Nombre'); ?></th>
                                <th><?php echo ('Estado'); ?></th>
                                <th class="actions"><?php echo __('Acciones'); ?></th>
                </tr>
                <?php foreach ($regionales as $regionale): ?>
                <tr>
                        <td><?php echo h($regionale['Regionale']['descripcion']); ?>&nbsp;</td>
                        <td>
                                <?php echo h($regionale['Estadoregistro']['descripcion']); ?>
                        </td>

                        <td class="actions">
                            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye fa-lg')), array('action' => 'view', $regionale['Regionale']['id']), array('escape' => false)) ?>
                            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $regionale['Regionale']['id']), array('escape' => false)) ?>
                            
                            <?php if($regionale['Estadoregistro']['id']==1){
                                        echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-thumbs-down fa-lg')). "", array('action' => 'inactivar', $regionale['Regionale']['id']),
                                        array('escape'=>false), __('Está seguro que desea inactivar la Regional %s?', $regionale['Regionale']['descripcion']), array('class' => 'btn btn-mini'));
                                    }else{
                                        echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-thumbs-up fa-lg')). "", array('action' => 'inactivar', $regionale['Regionale']['id']),
                                        array('escape'=>false), __('Está seguro que desea activar la Regional %s?', $regionale['Regionale']['descripcion']), array('class' => 'btn btn-mini'));
    
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
                echo "No hay regionales registradas en el sistema.";
            }
        ?>
</div>
