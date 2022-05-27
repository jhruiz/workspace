<?php echo ($this->Html->script('usuarios/cambiarcontrasena.js'));  ?>
<?php $this->layout='inicio'; ?>
<style type="text/css">
label {
            float: left;
            width: 150px;
            display: block;
            clear: left;
            text-align: left;
            cursor: hand;
        } 
</style>
<div class="form">
<?php echo $this->Form->create('Usuario',array('method'=>'post', 'action'=>'admcontrasenia','onsubmit' => 'return validarConfirmacionContras()')); ?>
	<fieldset>
		<legend><h2><?php echo __('Cambiar Contraseña'); ?></h2></legend>
	<?php
		echo $this->Form->input('nombreUsuario', array('label' => '<b>Nombre Usuario</b>', 'value'=>$nombreUsuario, 'disabled'=>'true'));
                echo $this->Form->input('idUsuario', array('type' => 'hidden', 'value'=>$usuarioId));
		echo $this->Form->input('password', array('label' => '<b>Password Nuevo</b>', 'type'=>'password', 'id' => 'UsuarioPassword', 'onBlur' => 'validarContrasena();'));
                echo $this->Form->input('contraseniaConf', array('label' => '<b>Confirmar Password</b>', 'type'=>'password', 'id' => 'txtConfPass', 'onBlur' => 'validarContrasenia();'));
	?>
	</fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
    </form>
</div>