<div class="solicitudreportes view">
<h2><?php echo __('Solicitudreporte'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tiporeporte'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['tiporeporte']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Regionale Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['regionale_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ciudade Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['ciudade_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Oficina Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['oficina_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fechainicial'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['fechainicial']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fechafinal'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['fechafinal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuarioauditor Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['usuarioauditor_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuarioejecutivo Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['usuarioejecutivo_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuariosolicitud Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['usuariosolicitud_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado Id'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['estado_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Urlarchivo'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['urlarchivo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estadosolicitud'); ?></dt>
		<dd>
			<?php echo h($solicitudreporte['Solicitudreporte']['estadosolicitud']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Solicitudreporte'), array('action' => 'edit', $solicitudreporte['Solicitudreporte']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Solicitudreporte'), array('action' => 'delete', $solicitudreporte['Solicitudreporte']['id']), null, __('Are you sure you want to delete # %s?', $solicitudreporte['Solicitudreporte']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Solicitudreportes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Solicitudreporte'), array('action' => 'add')); ?> </li>
	</ul>
</div>
