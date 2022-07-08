<?php 
    $this->layout = 'inicio'; 
?>

<div class="ubicacionesfisicas form">
    <?php echo $this->Form->create('Ubicacionesfisica'); ?>
        <fieldset>
            <legend><h2><?php echo __('Agregar Ubicación'); ?></h2></legend>
        <?php
            echo $this->Form->input('descripcion');
        ?>
        </fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>


