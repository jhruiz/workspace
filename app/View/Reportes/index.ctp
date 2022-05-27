<?php $this->layout = 'inicio'; ?>
<div class="reportes form">
    <fieldset>
        <legend><?php echo __('Generador de Reportes'); ?></legend>
        <table width="100%" class="CSSTable" >
            <tr>
                <th colspan="4">Seleccione el informe a generar</th>
            </tr>
            <tr>
                <td><?php echo $this->Html->link(__('Estado de paquetes'), array('controller' => 'reportes', 'action' => 'estadopaquetes')); ?></td>
                <td><?php echo $this->Html->link(__('Consulta Facturas'), array('controller' => 'reportes', 'action' => 'tiempospromedio')); ?></td>
                <td><?php echo $this->Html->link(__('Consulta por Indices'), array('controller' => 'reportes', 'action' => 'diasenespera')); ?></td>                
            </tr>
        </table>
    </fieldset>
</div>
