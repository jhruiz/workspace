<?php $this->layout = 'inicio'; ?>
<div class="tipodocumentos form">
<?php echo $this->Form->create('Tipodocumento'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Tipodocumento'); ?></h2></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden'));
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
		echo $this->Form->input('codigo', array('label' => 'Código'));
		echo $this->Form->input('serie_id');
	?>
	</fieldset><br>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Tipo Documentos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Series'), array('controller' => 'series', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Serie'), array('controller' => 'series', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
