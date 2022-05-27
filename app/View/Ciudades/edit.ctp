<?php $this->layout = 'inicio'; ?>
<div class="form">
<?php echo $this->Form->create('Ciudade'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Ciudad'); ?></h2></legend>
                
                <table>
                     <?php echo $this->Form->input('id',array('type'=>'hidden')); ?>
                    <tr>
                        <td>
                             <?php echo $this->Form->input('descripcion',array('label' => 'Nombre', 'class' => "alfanumeric"));?><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                             <?php  echo $this->Form->input('regionale_id',array('label' => 'Regional'));?><br>                          
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('estadoregistro_id',array('label'=>'Estado')); ?><br>
                        </td>
                    </tr>
                 </table>	
	</fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
    </form>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>	
		<li><?php echo $this->Html->link(__('Lista Ciudades'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Regionales'), array('controller' => 'regionales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Regional'), array('controller' => 'regionales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Oficinas'), array('controller' => 'oficinas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Oficina'), array('controller' => 'oficinas', 'action' => 'add')); ?> </li>
	</ul>
</div>
