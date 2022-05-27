<?php $this->layout = 'inicio'; ?>
<div class="estadopaquetes form">
<?php echo $this->Form->create('Reporte',array( 'controller' => 'reportes','action'=>'generar_motivostraslados')); ?>
    <fieldset>
        <legend><h2><br /><?php echo __('Generador de Reportes - Motivos de Traslados'); ?></h2></legend>
        <br />
        <table width="100%">
            <tr>
                <td><div><?php echo $this->Form->input('motivos', array('label' => __('Motivos de Traslado'), 'options' => $motivos, 'empty' => __('Todos'))); ?></div></td>
                <td><div><?php echo $this->Form->input('credencial', array('label' => __('Número Credencial'))); ?></div></td>
                <td><div><?php echo $this->Form->input('usuario', array('label' => __('Usuario Asignado'))); ?></div></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('regional', array('label' => __('Regional'), 'options' => $regional, 'empty' => __('Todas'), 'onChange'=>'obtenerCiudades()')); ?></td>
                <td><div id="divCiudades"><?php echo $this->Form->input('ciudad', array('label' => __('Ciudad'), 'options' => $ciudad, 'empty' => __('Todas'), 'onChange'=>'obtenerOficinas()' )); ?></div></td>
                <td><div id="divOficinas"><?php echo $this->Form->input('oficina', array('label' => __('Oficina'), 'options' => $oficina, 'empty' => __('Todas'))); ?></div></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo $this->Form->input('tipo', array('label' => __('Visualizar en'), 'options' => array('0'=>'Pantalla', '1' => 'Excel'))); ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2"><?php echo $this->Form->submit('Generar Reporte',array('class'=>'btn btn-info')); ?></td>                
            </tr>
        </table>
    </fieldset>
</div>