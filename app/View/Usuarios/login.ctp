<?php $this->layout = 'inicio'; ?>
<?php echo ($this->Html->script('login/login.js')); ?>    


<div class="usuarios form span6 offset6" style="margin-top:10%; text-align: center;">
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('Usuario',array( 'controller' => 'usuarios','action'=>'login')); ?>
    <fieldset>
        <legend><?php echo __('Por favor ingrese su nombre de usuario y contraseña'); ?></legend>
        <?php 
            echo $this->Form->input('username',array('label'=>'Nombre Usuario','class' => "alfanumeric_punto"));
            echo $this->Form->input('password',array('label'=>'Contraseña','autocomplete' => 'off'));
            echo $this->Form->input('isLogin',array('id' => 'isLogin',  'type' => 'hidden','value' => true));
        ?>
    </fieldset>
    <?php echo $this->Form->submit('Ingresar',array('class'=>'btn btn-info'));?>
    </form>
</div>