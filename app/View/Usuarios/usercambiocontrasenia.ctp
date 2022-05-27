<?php
$this->layout = 'inicio';
?>
<?php echo ($this->Html->script('usuarios/cambiarcontrasena.js'));  ?>
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
<div class="usuarios form">
    <?php echo $this->Form->create('Usuario', array('method' => 'post', 'action' => 'usercambiocontrasenia','onsubmit' => 'return validarConfirmacionContras()')); ?>
    <fieldset>
        <legend><h2><?php echo __('Cambiar Contraseña'); ?></h2></legend>
        <?php
        if (isset($mensaje)) {
            echo $mensaje;
        }
        ?>
        <table>
            <tr>
                <td>
                    <?php
                        echo $this->Form->input('passwordAnt', array('label' => '<b>Contraseña Anterior</b>', 'type' => 'password', 'id' => 'UsuarioPasswordA'));  
                        echo $this->Form->input('Usuario.id',array('id' => 'selusuario','type'=>'hidden','value'=>$usuario_id));
                    ?> 
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                        echo $this->Form->input('password', array('label' => '<b>Contraseña Nueva</b>', 'type' => 'password', 'id' => 'UsuarioPassword'));
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                        echo $this->Form->input('contraseniaConf', array('label' => '<b>Confirmar Contraseña</b>', 'type' => 'password', 'id' => 'txtConfPass'));
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <?php echo $this->Form->submit('Guardar', array('class' => 'btn btn-info')); ?>

</form>
</div>