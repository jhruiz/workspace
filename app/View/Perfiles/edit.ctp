<?php
    $this->layout='inicio';
?>

<div class="form">
<?php echo $this->Form->create('Perfile'); ?>
	<fieldset>
            <legend><h2><?php echo __('Editar Perfil'); ?></h2></legend>
	<?php
                echo $this->Form->input('id');
		echo $this->Form->input('descripcion', array('label' => "Nombre"));
	?>
	</fieldset><br>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
    </form>
</div>
<div class="actions">
    <legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
                <li><?php echo $this->Html->link(__('Lista Perfiles'), array('controller' => 'perfiles', 'action' => 'index')); ?> </li>            
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>

