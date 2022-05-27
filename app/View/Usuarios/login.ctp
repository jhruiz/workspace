<?php $this->layout = 'inicio'; ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#UsuarioUsername").focus();
    });
</script>
    

<div class="usuarios form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('Usuario',array( 'controller' => 'usuarios','action'=>'login')); ?>
    <fieldset>
        <legend><?php echo __('Por favor ingrese su nombre de usuario y contraseña'); ?></legend>
        <?php echo $this->Form->input('username',array('label'=>'Nombre Usuario','class' => "alfanumeric_punto"));
        echo $this->Form->input('password',array('label'=>'Contraseña','autocomplete' => 'off'));
        echo $this->Form->input('isLogin',array('id' => 'isLogin',  'type' => 'hidden','value' => true));
        
    ?>
    </fieldset>
<?php //echo $this->Form->end(__('Login')); ?>
    <?php echo $this->Form->submit('Ingresar',array('class'=>'btn btn-info'));?>
    </form>
</div>