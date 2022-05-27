<?php $this->layout = 'inicio'; ?>
<div class="solicitudreportes index">
	<legend><h2><?php echo __('Lista Reporte de Solicitudes'); ?></h2></legend>
	<table cellpadding="0" cellspacing="0" class="CSSTable">
	<tr>
			<th><?php echo $this->Paginator->sort('fechainicial', 'Fecha Inicial'); ?></th>
			<th><?php echo $this->Paginator->sort('fechafinal', 'Fecha Final'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($solicitudreportes as $solicitudreporte): ?>
	<tr>
		<td><?php echo h($solicitudreporte['Solicitudreporte']['fechainicial']); ?>&nbsp;</td>
		<td><?php echo h($solicitudreporte['Solicitudreporte']['fechafinal']); ?>&nbsp;</td>
		<td class="actions">
                    <?php
                    if ($solicitudreporte['Solicitudreporte']['estadosolicitud'] == '2') {                        
                        $options['http'] = array(
                            'method' => "HEAD",
                            'ignore_errors' => 1,
                            'max_redirects' => 0
                        );

                        $body = @file_get_contents($solicitudreporte['Solicitudreporte']['urlarchivo'], NULL, stream_context_create($options));
                        if (isset($http_response_header)) {                           
                            sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode);

                            //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
                            $accepted_response = array(200, 301, 302);
                            if (in_array($httpcode, $accepted_response)) {
                                echo "<input type='button' class='btn btn-info' value='descargar' onclick='window.location.href=\"" . $solicitudreporte['Solicitudreporte']['urlarchivo'] . "\"' />&nbsp;&nbsp;&nbsp;";
                            } else {
                                echo "<div>No hay registros para este rango de fechas</div>";
                            }
                        } else {
                            echo "<div>No hay registros para este rango de fechas</div>";
                        }                                                
                    } else if($solicitudreporte['Solicitudreporte']['estadosolicitud'] == '3'){
                        echo "<div>Se genero un error en la creación del reporte</div>";
                    } else if($solicitudreporte['Solicitudreporte']['estadosolicitud'] == '4'){
                        echo "<div>No hay registros para este rango de fechas</div>";
                    }
                    
                    echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $solicitudreporte['Solicitudreporte']['id'], 'listareportegeneral', '1'), null, __('Está seguro que desea eliminar el registro?'));
                    ?>                    
                    
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, mostrando {:current} registro de {:count} en total, iniciando en registro {:start}, finalizando en {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | | '));
		echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nueva Solicitud de Reporte'), array('action' => 'reportegeneral')); ?></li>
	</ul>
</div>
