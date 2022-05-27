<?php
    $this->layout='inicio';
    echo $this->Html->script('paquetesusuarios/listasolicitudes.js');    
?>
<script type="text/javascript">
    var urlBase = <?php echo json_encode(Router::url('/')); ?>;    
</script>


<div class="usuarios index">
        <legend><h2><?php echo __('Lista Solicitudes por Usuario'); ?></h2></legend>
        <table class="table table-striped">
	<tr>
			<th><?php echo __('Solicitud'); ?></th>
                        <th><?php echo __('Credencial'); ?></th>
                        <th><?php echo __('Estado'); ?></th>
                        <th><?php echo __('Oficina'); ?></th>
						<th><?php echo __('Fecha Digitalización'); ?></th>						
                        <th><?php echo __('Fecha Asignación Solicitud'); ?></th>
                        <th><?php echo __('Días'); ?></th>			
			<th class="actions"><?php echo __('Acciones'); ?></th>
                        <th><?php echo __('Trasladar'); ?></th>
	</tr>        
	<?php foreach ($arrSolicitudes as $solicitud): ?> 
	
	<tr>                
                <td><input type="hidden" id="<?php echo $solicitud['PaquetesUsuario']['paquete_id']; ?>" value='<?php echo $solicitud['PaquetesUsuario']['id']; ?>'>
		<?php echo h($solicitud['PQ']['numerosolicitud']); ?>&nbsp;</td>    
                <td><?php echo h($solicitud['PQ']['numerocredencial']); ?>&nbsp;</td>   
                <td><?php echo h($solicitud['EST']['descripcion']); ?>&nbsp;</td>
                <td><?php echo h($solicitud['OFI']['descripcion']); ?>&nbsp;</td>
				<td><?php echo h($solicitud['PQ']['fechacreacion']); ?>&nbsp;</td> 
                <td><?php echo h($solicitud['TZ']['created']); ?>&nbsp;</td>   				
                <td><?php echo h($solicitud['TZ']['dias']); ?>&nbsp;</td>   
                <td><?php echo $this->Html->link(__('Ver Detalle'), array('action' => 'infopaquete', $solicitud['PaquetesUsuario']['paquete_id'] , $solicitud['PaquetesUsuario']['usuario_id'])); ?></td>
                <?php if(isset($permisoTraslado['PrivilegiosUsuario']) && $permisoTraslado['PrivilegiosUsuario']['privilegio_id'] == '4'){?>
                    <?php if($solicitud['EST']['trasladopaquete'] == '1'){?>                
                    <td><div class="chkObtenerUsr"><input type="checkbox" id="<?php echo $solicitud['PaquetesUsuario']['paquete_id']?>" value="<?php echo $solicitud['PaquetesUsuario']['paquete_id']?>" onclick="obtenerUsuarioTraslado();"/></div></td>
                    <?php }else{?>
                        <td>&nbsp;</td>
                    <?php }?>
                <?php }else{?>
                    <td>&nbsp;</td>
                <?php }?> 
	</tr>        
<?php endforeach; ?>
        <?php if(isset($arrSolicitudes['0'])){?>
            <input type="hidden" name="usuarioId" id="usuarioId" value='<?php echo $arrSolicitudes['0']['PaquetesUsuario']['usuario_id']; ?>' >
        <?php } ?>
	</table> 
</div>
<br>
        <table style="margin: 0 auto;">
            <tr>
                <td align='center'>
                    <?php echo __('Trasladar a: '); ?><div class="traslado"><select id="usrTraslado"></select></div>                                        
                </td>
            </tr>
            <tr>
                <td align='center'>
                    <button id="butTrasladar" class="btn btn-info" onclick="trasladarSolicitudesSeleccionadas()">Aprobar Traslado</button></td>               
                </td>                
            </tr>
        </table>

</br></br>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Volver al Listado'), array('controller' => 'usuarios', 'action' => 'listausuarios')); ?> </li>
	</ul>
</div>
<div id="div_traslado"></div>
