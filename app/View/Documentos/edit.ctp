<?php    
    $this->layout = 'inicio'; 
?>
<div class="documentos form">
<?php echo $this->Form->create('Documento'); ?>
	<fieldset>
		<legend><h2><?php echo __('Editar Documento'); ?></h2></legend>
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('descripcion', array('label' => 'Nombre'));
		echo $this->Form->input('tipodocumento_id', array('label' => 'Tipo Documento'));
	?>
	</fieldset><br>
<?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
</div>
<div class="actions">
    <legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Documentos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Tipo Documentos'), array('controller' => 'tipodocumentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Tipo Documento'), array('controller' => 'tipodocumentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
