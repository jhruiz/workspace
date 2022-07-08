<?php $this->layout = 'inicio'; ?>
<div class="etencionesSeries form">
<?php echo $this->Form->create('RetencionesSerie'); ?>
	<fieldset>
		<legend><h2><?php echo __('Agregar Retención Documental'); ?></h2></legend>
        <?php
		
        echo $this->Form->input('serie_id', array(
            'type' => 'select',
            'label' => 'Serie',
            'options' => $series,
            'empty' => 'Seleccione una...',
                )
        );

        echo $this->Form->input('cantidad', array('label' => 'Cantidad', 'type' => 'number'));
        
        echo $this->Form->input('unidadesmedida_id', array(
            'type' => 'select',
            'label' => 'Unidad de medida',
            'options' => $uMed,
            'empty' => 'Seleccione una...',
                )
        );

        echo $this->Form->input('acciondisposicione_id', array(
            'type' => 'select',
            'label' => 'Acciones',
            'options' => $acciones,
            'empty' => 'Seleccione una...',
                )
        );
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
