<?php $this->layout = 'inicio';?>
<div class="generar_estadopaquetes form">
    <fieldset>
        <legend><center>
            <h2><?php echo __($texto_tit); ?></h2>
        </center></legend>
        <table cellpadding="0" cellspacing="0" border="1" class="CSSTable" width="100%">
            <tr>
                
                <th><?php echo __('Fecha Asignacion'); ?></th>
                <th><?php echo __('No. Credencial'); ?></th>
                <th><?php echo __('No. Solicitud'); ?></th>
                <th><?php echo __('Auditor Asignado'); ?></th>
                <th><?php echo __('Fecha Traslado'); ?></th>
                <th><?php echo __('Auditor Recibe'); ?></th>
                <th><?php echo __('Motivo'); ?></th>
                <th><?php echo __('Regional'); ?></th>
                <th><?php echo __('Ciudad'); ?></th>
                <th><?php echo __('Oficina'); ?></th>
            </tr>
            <?php foreach ($arrMotivosTraslado as $motTras): ?>

            <tr>
                <td><?php echo h($motTras['PQ']['fechacreacion']); ?></td>
                <td><?php echo h($motTras['PQ']['numerocredencial']); ?></td>
                <td><?php echo h($motTras['PQ']['numerosolicitud']); ?></td>
                <td><?php echo h($motTras['USU']['nombre']); ?></td>
                <td><?php echo h($motTras['MotivostrasladosPaquete']['created']); ?></td>
                <td><?php echo h($motTras['U']['nombre']); ?></td>
                <td><?php echo h($motTras['MT']['descripcion']); ?></td>				
                <td><?php echo h($motTras['R']['descripcion']); ?></td>				
                <td><?php echo h($motTras['C']['descripcion']); ?></td>				
                <td><?php echo h($motTras['O']['descripcion']); ?></td>				
            </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>
</div>
