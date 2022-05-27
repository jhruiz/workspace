<?php $this->layout = 'inicio'; ?>
<div class="estados view">
<legend><h2><?php echo __('Estado del Proceso'); ?></h2></legend>
	<dl>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($estado['Estado']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado Inicial'); ?></dt>
		<dd>                    
			<?php 
                            if($estado['Estado']['estadoinicial'] == '1'){
                                echo h('SI');
                            }else{
                                echo h('NO');
                            }
                        ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado Final'); ?></dt>
		<dd>
			<?php
                            if($estado['Estado']['estadofinal'] == '1'){
                                echo h('SI');
                            }else{
                                echo h('NO');
                            }
                        ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado Anulado'); ?></dt>
		<dd>
			<?php
                            if($estado['Estado']['estadoanulado'] == '1'){
                                echo h('SI');
                            }else{
                                echo h('NO');
                            }
                        ?>                    
			&nbsp;
		</dd>
		<dt><?php echo __('Adjuntar Archivos'); ?></dt>
		<dd>
			<?php
                            if($estado['Estado']['adjuntararchivos'] == '1'){
                                echo h('SI');
                            }else{
                                echo h('NO');
                            }
                        ?>                       
			&nbsp;
		</dd>
		<dt><?php echo __('Permite Transferencia'); ?></dt>
		<dd>
			<?php
                            if($estado['Estado']['trasladopaquete'] == '1'){
                                echo h('SI');
                            }else{
                                echo h('NO');
                            }
                        ?>                       
			&nbsp;
		</dd>                
	</dl>
</div>
<div class="actions">
	<legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Estado'), array('action' => 'edit', $estado['Estado']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Estados'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Estado'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Bandejas'), array('controller' => 'bandejas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Bandeja'), array('controller' => 'bandejas', 'action' => 'add')); ?> </li>
	</ul>
</div>