<?php $this->layout = 'inicio';
?>
<div class="generar_diasenespera form">
    <fieldset>
        <legend><center>
            <h2><?php echo __('Dias en gestión por estado'); ?></h2>
        </center></legend>
        <table class="table table-striped" width="100%">
            <tr>
                <th><?php echo __('NUM. CREDENCIAL'); ?></th>
                <th><?php echo __('NUN. SOLICITUD'); ?></th>
                <th><?php echo __('ESTADO'); ?></th>                       
                <th><?php echo __('USUARIO'); ?></th>
                <th><?php echo __('FECHA CREACI&Oacute;N'); ?></th> 
                <th><?php echo __('REGIONAL'); ?></th>
                <th><?php echo __('CIUDAD'); ?></th>
                <th><?php echo __('OFICINA'); ?></th>
                <th><?php echo __('CANTIDAD DE DIAS'); ?></th>

            </tr>
            <?php foreach ($paquetesDias as $paquete): ?>
            <tr>
                <td><?php echo h($paquete['P']['numerocredencial']); ?></td>
                <td><?php echo h($paquete['P']['numerosolicitud']); ?></td>
                <td><?php echo h($paquete['E']['descripcion']); ?></td>
                <td><?php echo h($paquete['U']['nombre']); ?></td>
                <td><?php echo h($paquete['Trazabilidade']['created']); ?></td>
                <td><?php echo h($paquete['R']['descripcion']); ?></td>
                <td><?php echo h($paquete['C']['descripcion']); ?></td>
                <td><?php echo h($paquete['O']['descripcion']); ?></td>                
                <td>
                    <?php 
                        $fechaActual = date("Y-m-d");
                        $fechaAnterior = strtotime(h($paquete['Trazabilidade']['created']));
                        $dias = (strtotime($fechaActual)-$fechaAnterior)/86400;
                        $dias = abs($dias); $dias = floor($dias);
                        echo $dias;
                    ?>
                </td>                
            </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>
</div>