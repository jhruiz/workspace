<?php echo ($this->Html->script('usuarios/usuarios.js')); ?> 
<?php echo ($this->Html->script('usuarios/gestionusuarios.js'));  ?>
<?php
    $this->layout='inicio';
?>
<div class="form">
<?php echo $this->Form->create('Usuario'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Usuario'); ?></h2></legend>                                
                <table>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('id'); ?>
                            <?php echo $this->Form->input('nombre',array('class' => "alfanumeric")); ?><br>
                        </td>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br></td>                            
                        <td>
                            <?php echo $this->Form->input('username', array('label' => 'Login','class' => "alfanumeric_punto")); ?><br>
                        </td>                        
                    </tr>          
                    
                    <tr>
                        <td>
                            <?php echo $this->Form->input('correoelectronico', array('label' => 'Correo Electrónico')); ?><br>
                        </td>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br></td>                                                   
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('identificacion', array('label' => 'Identificación','class' => "alfanumeric")); ?><br>
                            <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br></td> 
                        </td>
                        <td>                            
                            <?php echo $this->Form->input('perfile_id', array('label' => 'Perfil', 'id' => 'perfile_id')); ?><br>
                        </td>                        
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php echo $this->Form->input('estadoregistro_id', array('label' => 'Estado Registro')); ?><br>
                        </td>                                                  
                    </tr>
                </table>                
	</fieldset>

    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
    <br>
    <br>
    </form>
    
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<!--<li><?php echo $this->Form->postLink(__('Cambiar Estado'), array('action' => 'inactivar', $this->Form->value('Usuario.id')), null, __('Está seguro que desea cambiar el estado del Usuario %s?', $this->Form->value('Usuario.nombre'))); ?></li>-->
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Nuevo Perfil'), array('controller' => 'perfiles', 'action' => 'add')); ?> </li>        
		<li><?php echo $this->Html->link(__('Nueva Oficina'), array('controller' => 'oficinas', 'action' => 'add')); ?> </li>
	</ul>
</div>
