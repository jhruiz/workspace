<?php $this->layout = 'inicio';?>
<div class="generar_estadopaquetes form">
    <fieldset>
        <legend><center>
            <h2><?php echo __('Estados'); ?></h2>
        </center></legend>
        <table class="table table-striped" width="100%">
            <tr>
                
                <th><?php echo __('Num. Credencial'); ?></th>
                <th><?php echo __('Num. Solicitud'); ?></th>
                <th><?php echo __('Fecha Creación'); ?></th>
                <th><?php echo __('Estado Actual'); ?></th>
                <th><?php echo __('Usuario Asignado'); ?></th>
                <th><?php echo __('Regional'); ?></th>
                <th><?php echo __('Ciudad'); ?></th>
                <th><?php echo __('Oficina'); ?></th>
            </tr>
            <?php foreach ($paquetes as $paquete): ?>
            <tr>
                <td><?php echo h($paquete['Paquete']['numerocredencial']); ?></td>
                <td><?php echo h($paquete['Paquete']['numerosolicitud']); ?></td>
                <td><?php echo h($paquete['Paquete']['fechacreacion']); ?></td>
                <td><?php echo h($paquete['E']['descripcion']); ?></td>
                <td>
                    <?php if (isset($paquete['U']['nombre'])){
                        echo h($paquete['U']['nombre']); 
                    }                   
                    ?>
                </td>
                <td><?php echo h($paquete['R']['descripcion']); ?></td>
                <td><?php echo h($paquete['C']['descripcion']); ?></td>
                <td><?php echo h($paquete['O']['descripcion']); ?></td>				
            </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>
</div>
