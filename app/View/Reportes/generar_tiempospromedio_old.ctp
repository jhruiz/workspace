<?php $this->layout = 'inicio'; ?>
<div class="generar_estadopaquetes form">
    <fieldset>
        <legend><center>
            <?php echo __('Consolidado de Solicitudes Digitalizadas'); ?>
        </center></legend>
        <table cellpadding="0" cellspacing="0" border="1" class="CSSTable" width="100%">
            <tr>
                <th><?php echo __('NUMERO DE CREDENCIAL'); ?></th>
                <th><?php echo __('NUMERO DE SOLICITUD'); ?></th>
                <th><?php echo __('ESTADO'); ?></th>
                <th><?php echo __('USUARIO'); ?></th>
                <th><?php echo __('OFICINA'); ?></th>
                <th><?php echo __('FECHA'); ?></th>
                <th><?php echo __('DIAS'); ?></th>
            </tr>
            <?php foreach ($trazas as $traza):?>
			
            <tr>
                <td><?php echo h($traza['Paquete']['numerocredencial']); ?></td>
                <td><?php echo h($traza['Paquete']['numerosolicitud']); ?></td>
                <td><?php echo h($traza['Estadodestino']['descripcion']); ?></td>
                <td><?php echo h($traza['Usuario']['nombre']); ?></td>
                <td><?php echo h($traza['Paquete']['nombre_oficina']); ?></td>                
                <td><?php echo h($traza['Trazabilidade']['created']); ?></td>
                <td><?php echo h($traza['Trazabilidade']['diaspromedio']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br />
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de {:count} en total')
            ));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | '));
		echo $this->Paginator->next(__(' Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
                echo $this->Js->writeBuffer(); 
	?>
	</div>
    </fieldset>
</div>