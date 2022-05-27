<?php $this->layout = 'inicio'; ?>
<div class="menusPerfiles form">
<?php echo $this->Form->create('MenusPerfile'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Menú - Perfil'); ?></h2></legend>
	<?php
		echo $this->Form->input('menu_id');
		echo $this->Form->input('perfile_id');
	?>
	</fieldset><br>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>  
