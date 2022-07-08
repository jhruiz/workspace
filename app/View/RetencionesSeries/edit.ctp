<?php $this->layout = 'inicio'; ?>
<div class="RetencionesSeries form">
<?php echo $this->Form->create('RetencionesSerie'); ?>
	<fieldset>
            <legend><h2><?php echo __('Editar Retención Documental'); ?></h2></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden', 'value' => $retencion['RetencionesSerie']['id']));

        echo $this->Form->input('serie_id', array(
            'type' => 'select',
            'label' => 'Serie',
            'options' => $series,
            'empty' => 'Seleccione una...',
            'default' => $retencion['RetencionesSerie']['serie_id'],
            'disabled' => true
            )
        );

        echo $this->Form->input('cantidad', array('label' => 'Cantidad', 'type' => 'number', 'value' => $retencion['RetencionesSerie']['cantidad']));
        
        echo $this->Form->input('unidadesmedida_id', array(
            'type' => 'select',
            'label' => 'Unidad de medida',
            'options' => $uMed,
            'empty' => 'Seleccione una...',
            'default' => $retencion['RetencionesSerie']['unidadesmedida_id']
            )
        );

        echo $this->Form->input('acciondisposicione_id', array(
            'type' => 'select',
            'label' => 'Acciones',
            'options' => $acciones,
            'empty' => 'Seleccione una...',
            'default' => $retencion['RetencionesSerie']['acciondisposicione_id'],
            )
        );
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
