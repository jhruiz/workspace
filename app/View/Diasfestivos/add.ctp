<?php $this->layout = 'inicio'; ?>
<?php echo $this->Html->css('datepicker'); ?>
<?php echo ($this->Html->script('bandeja/gestionBandejas.js'));  ?>
<div class="diasfestivos form">
<?php echo $this->Form->create('Diasfestivo'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Día Festivo'); ?></h2></legend>               
                Día Festivo: <input type="text" name="data[Diasfestivo][fecha]" class="date"><br>
	<?php
		echo $this->Form->input('descripcion', array('label' => __('Descripción: ')));
	?>
	</fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
