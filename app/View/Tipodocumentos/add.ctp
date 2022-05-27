<?php 
    $this->layout = 'inicio'; 
?>
<div class="tipodocumentos form">
<?php echo $this->Form->create('Tipodocumento'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agragar Tipo Documentos'); ?></h2></legend>
	<?php
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
		echo $this->Form->input('codigo', array('label', 'Código'));
		echo $this->Form->input('serie_id');
	?>
        </fieldset><br>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?><br>
</div>
