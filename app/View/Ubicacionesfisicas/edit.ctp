<?php 
    $this->layout = 'inicio'; 
?>

<div class="ubicacionesfisicas form">
    <?php echo $this->Form->create('Ubicacionesfisica'); ?>
        <fieldset>
            <legend><h2><?php echo __('Editar Ubicación'); ?></h2></legend>
        <?php
            echo $this->Form->input('id',array('type'=>'hidden'));
            echo $this->Form->input('descripcion', array('value' => $ubicacion['Ubicacionesfisica']['descripcion']));
        ?>
        </fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>


