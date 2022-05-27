<?php $this->layout = 'inicio'; ?>
<div class="menus form">
<?php echo $this->Form->create('Menu'); ?>
	<fieldset>
            <legend><h2><?php echo __('Editar Menú'); ?></h2></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden'));
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
		echo $this->Form->input('url');
                    echo $this->Form->input('menu_id', array(
                        'type' => 'select',
                        'label' => 'Menú Padre',
                        'options' => $menus,
                        'empty' => 'Seleccione una...',
                            )
                    );
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
