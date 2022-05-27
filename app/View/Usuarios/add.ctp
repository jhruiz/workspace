<?php echo ($this->Html->script('usuarios/usuarios.js')); ?> 
<?php echo ($this->Html->script('usuarios/gestionusuarios.js')); ?>
<?php
    $this->layout='inicio';
?>
<div class="usuarios form">
<?php echo $this->Form->create('Usuario',array('onsubmit' => 'return validarFormUsu()')); ?>
	<fieldset>
		<legend><h2><?php echo __('Nuevo Usuario'); ?></h2></legend><br>
            <table border="0"> 
                <tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('nombre', array('class' => "alfanumeric")); ?><br>
                        </td>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br></td>                            
                        <td>
                            <?php echo $this->Form->input('username', array('label' => 'Login','class' => "alfanumeric_punto")); ?> <br>   
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            <?php echo $this->Form->input('correoelectronico', array('label' => 'e-Mail')); ?><br>                               
                        </td>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br></td>                            
                        <td>
                            <?php echo $this->Form->input('password'); ?><br>
                        </td>                        
                    </tr> 
                    <tr>
                        <td>
                            <?php echo $this->Form->input('identificacion', array('label' => 'Identificación')); ?><br>  
                        </td>                          
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br></td>                            
                        <td>
                            <?php echo $this->Form->input('confirm', array('label' => 'Confirmar Password', 'type'=>'password', 'id' => 'txtConfPass', 'onBlur' => 'validarContrasenia();')); ?><br>  
                        </td>                        
                    </tr>   
                    <tr>
                        <td>
                            <?php echo $this->Form->input('perfile_id', array('label' => 'Perfil', 'id' => 'perfile_id')); ?><br>
                        </td>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php echo $this->Form->input('estadoregistro_id', array('label' => 'Estado Registro')); ?> <br>
                        </td>
                    </tr>                                  
                </tr>
            </table>
	</fieldset>
    <br>
   <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
