<div class="paquetes view">
<h2><?php echo __('Paquete'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($paquete['Paquete']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Creacion'); ?></dt>
		<dd>
			<?php echo h($paquete['Paquete']['fecha_creacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Digitalizacion'); ?></dt>
		<dd>
			<?php echo h($paquete['Paquete']['fecha_digitalizacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Recepcion Embargo'); ?></dt>
		<dd>
			<?php echo h($paquete['Paquete']['fecha_recepcion_embargo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numero Oficio'); ?></dt>
		<dd>
			<?php echo h($paquete['Paquete']['numero_oficio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo $this->Html->link($paquete['Estado']['descripcion'], array('controller' => 'estados', 'action' => 'view', $paquete['Estado']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Oficina'); ?></dt>
		<dd>
			<?php echo $this->Html->link($paquete['Oficina']['descripcion'], array('controller' => 'oficinas', 'action' => 'view', $paquete['Oficina']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Paquete'), array('action' => 'edit', $paquete['Paquete']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Paquete'), array('action' => 'delete', $paquete['Paquete']['id']), null, __('Are you sure you want to delete # %s?', $paquete['Paquete']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Paquetes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paquete'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estados'), array('controller' => 'estados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estado'), array('controller' => 'estados', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Oficinas'), array('controller' => 'oficinas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oficina'), array('controller' => 'oficinas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Observaciones'), array('controller' => 'observaciones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observacione'), array('controller' => 'observaciones', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Trazabilidades'), array('controller' => 'trazabilidades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trazabilidade'), array('controller' => 'trazabilidades', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Eliminarmultis'), array('controller' => 'eliminarmultis', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eliminarmulti'), array('controller' => 'eliminarmultis', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('controller' => 'documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Observaciones'); ?></h3>
	<?php if (!empty($paquete['Observacione'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Descripcion'); ?></th>
		<th><?php echo __('Paquete Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($paquete['Observacione'] as $observacione): ?>
		<tr>
			<td><?php echo $observacione['id']; ?></td>
			<td><?php echo $observacione['descripcion']; ?></td>
			<td><?php echo $observacione['paquete_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'observaciones', 'action' => 'view', $observacione['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'observaciones', 'action' => 'edit', $observacione['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'observaciones', 'action' => 'delete', $observacione['id']), null, __('Are you sure you want to delete # %s?', $observacione['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Observacione'), array('controller' => 'observaciones', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Trazabilidades'); ?></h3>
	<?php if (!empty($paquete['Trazabilidade'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Estado Id'); ?></th>
		<th><?php echo __('Estadodestino Id'); ?></th>
		<th><?php echo __('Paquete Id'); ?></th>
		<th><?php echo __('Usuario Id'); ?></th>
		<th><?php echo __('Indicador Actual'); ?></th>
		<th><?php echo __('Paquetesusuario Id'); ?></th>
		<th><?php echo __('Diaspromedio'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($paquete['Trazabilidade'] as $trazabilidade): ?>
		<tr>
			<td><?php echo $trazabilidade['id']; ?></td>
			<td><?php echo $trazabilidade['estado_id']; ?></td>
			<td><?php echo $trazabilidade['estadodestino_id']; ?></td>
			<td><?php echo $trazabilidade['paquete_id']; ?></td>
			<td><?php echo $trazabilidade['usuario_id']; ?></td>
			<td><?php echo $trazabilidade['indicador_actual']; ?></td>
			<td><?php echo $trazabilidade['paquetesusuario_id']; ?></td>
			<td><?php echo $trazabilidade['diaspromedio']; ?></td>
			<td><?php echo $trazabilidade['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'trazabilidades', 'action' => 'view', $trazabilidade['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'trazabilidades', 'action' => 'edit', $trazabilidade['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'trazabilidades', 'action' => 'delete', $trazabilidade['id']), null, __('Are you sure you want to delete # %s?', $trazabilidade['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Trazabilidade'), array('controller' => 'trazabilidades', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Eliminarmultis'); ?></h3>
	<?php if (!empty($paquete['Eliminarmulti'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Paquete Id'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($paquete['Eliminarmulti'] as $eliminarmulti): ?>
		<tr>
			<td><?php echo $eliminarmulti['id']; ?></td>
			<td><?php echo $eliminarmulti['paquete_id']; ?></td>
			<td><?php echo $eliminarmulti['estado']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'eliminarmultis', 'action' => 'view', $eliminarmulti['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'eliminarmultis', 'action' => 'edit', $eliminarmulti['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'eliminarmultis', 'action' => 'delete', $eliminarmulti['id']), null, __('Are you sure you want to delete # %s?', $eliminarmulti['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Eliminarmulti'), array('controller' => 'eliminarmultis', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Usuarios'); ?></h3>
	<?php if (!empty($paquete['Usuario'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Identificacion'); ?></th>
		<th><?php echo __('Correo Electronico'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Perfile Id'); ?></th>
		<th><?php echo __('Estadoregistro Id'); ?></th>
		<th><?php echo __('Num Intentos'); ?></th>
		<th><?php echo __('Oficina Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($paquete['Usuario'] as $usuario): ?>
		<tr>
			<td><?php echo $usuario['id']; ?></td>
			<td><?php echo $usuario['nombre']; ?></td>
			<td><?php echo $usuario['identificacion']; ?></td>
			<td><?php echo $usuario['correoelectronico']; ?></td>
			<td><?php echo $usuario['username']; ?></td>
			<td><?php echo $usuario['password']; ?></td>
			<td><?php echo $usuario['perfile_id']; ?></td>
			<td><?php echo $usuario['estadoregistro_id']; ?></td>
			<td><?php echo $usuario['num_intentos']; ?></td>
			<td><?php echo $usuario['oficina_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'usuarios', 'action' => 'view', $usuario['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'usuarios', 'action' => 'edit', $usuario['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'usuarios', 'action' => 'delete', $usuario['id']), null, __('Are you sure you want to delete # %s?', $usuario['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Documentos'); ?></h3>
	<?php if (!empty($paquete['Documento'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Descripcion'); ?></th>
		<th><?php echo __('Tipodocumento Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($paquete['Documento'] as $documento): ?>
		<tr>
			<td><?php echo $documento['id']; ?></td>
			<td><?php echo $documento['descripcion']; ?></td>
			<td><?php echo $documento['tipodocumento_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'documentos', 'action' => 'view', $documento['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'documentos', 'action' => 'edit', $documento['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'documentos', 'action' => 'delete', $documento['id']), null, __('Are you sure you want to delete # %s?', $documento['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Documento'), array('controller' => 'documentos', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
