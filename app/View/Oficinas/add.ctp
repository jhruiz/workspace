<?php
    $this->layout='inicio';
?>
<div class="oficinas form">
<?php echo $this->Form->create('Oficina'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Oficina'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion',array('label' => "Nombre"));
		echo $this->Form->input('ciudade_id',array('label' => 'Ciudad'));
                echo $this->Form->input('estadoregistro_id',array('label' => 'Estado'));
	?>
	</fieldset>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<br>
</form>
