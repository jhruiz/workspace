<div class="solicitudreportes form">
<?php echo $this->Form->create('Solicitudreporte'); ?>
	<fieldset>
		<legend><?php echo __('Add Solicitudreporte'); ?></legend>
	<?php
		echo $this->Form->input('tiporeporte');
		echo $this->Form->input('regionale_id');
		echo $this->Form->input('ciudade_id');
		echo $this->Form->input('oficina_id');
		echo $this->Form->input('fechainicial');
		echo $this->Form->input('fechafinal');
		echo $this->Form->input('usuarioauditor_id');
		echo $this->Form->input('usuarioejecutivo_id');
		echo $this->Form->input('usuariosolicitud_id');
		echo $this->Form->input('estado_id');
		echo $this->Form->input('urlarchivo');
		echo $this->Form->input('estadosolicitud');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Solicitudreportes'), array('action' => 'index')); ?></li>
	</ul>
</div>
