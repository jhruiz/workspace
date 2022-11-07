<?php $this->layout = 'inicio'; ?>
<div class="documentosPaquetes index">
	<h2><?php echo __('Documentos'); ?></h2>
	<table class="table table-striped">
	<tr>
			<th><?php echo ('Documento'); ?></th>
			<th><?php echo ('Paquete'); ?></th>
			<th><?php echo ('Fecha creación'); ?></th>
			<th><?php echo ('Fecha de disposición'); ?></th>
			<th><?php echo ('Días restantes'); ?></th>
			<th><?php echo ('Acción'); ?></th>
	</tr>
	<?php foreach ($documentosPaquetes as $documentospaquete): ?>
	<tr>
		<td>
			<?php echo ($documentospaquete['Documento']['descripcion']); ?>
		</td>
		<td>
			<?php echo ($documentospaquete['Paquete']['numerocredencial']); ?>
		</td>
		<td>
			<?php echo ($documentospaquete['DocumentosPaquete']['created']); ?>
		</td>
		<td>
			<?php echo ($documentospaquete['calcretencion']['fechaElim']); ?>
		</td>
		<td>
			<b><?php echo ($documentospaquete['calcretencion']['dias']); ?></b>
		</td>
		<td>
			<b><?php echo ($documentospaquete['calcretencion']['accion']); ?></b>
		</td>
		
	</tr>
<?php endforeach; ?>
</table>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
