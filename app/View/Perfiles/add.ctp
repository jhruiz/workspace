<?php
    $this->layout='inicio';
?>
<div class="perfiles form">
<?php echo $this->Form->create('Perfile'); ?>
	<fieldset>
		<legend><h2><?php echo __('Nuevo Perfil'); ?><h2></legend>
        </fieldset>
	<?php
		echo $this->Form->input('descripcion', array('class' => "alfanumeric"));
	?>
	
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
    </form>
</div>
