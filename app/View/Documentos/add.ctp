<?php    
    $this->layout = 'inicio'; 
?>

<div class="documentos form">
<?php echo $this->Form->create('Documento'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Documentos'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion',array('label' => 'Nombre'));
		echo $this->Form->input('tipodocumento_id', array('label' => 'Tipo Documento'));
	?>
	</fieldset><br>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
