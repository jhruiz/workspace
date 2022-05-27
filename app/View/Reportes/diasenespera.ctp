<?php echo $this->Html->css('datepicker'); ?>
<?php echo ($this->Html->script('bandeja/gestionBandejas.js'));  ?>
<?php echo ($this->Html->script('reportes/estadopaquetes')); ?> 
<?php $this->layout = 'inicio'; ?>
<div class="diasenespera form">
<?php echo $this->Form->create('Reporte',array( 'controller' => 'reportes','action'=>'generar_diasenespera')); ?>
    <fieldset>
        <legend><h2><?php echo __('Generador de Reportes - Dias en gestión por estado'); ?></h2></legend>
        <br />
        <table width="100%">
            <tr>
                <td><?php echo $this->Form->input('tipo', array('label' => __('Visualizar en'), 'options' => array('0'=>'Pantalla', '1' => 'Excel'))); ?></td>
                <td><div><?php echo $this->Form->input('fecha_inicio', array('label' => __('Desde'), 'class'=>'date')); ?></div></td>
                <td><div><?php echo $this->Form->input('fecha_fin', array('label' => __('Hasta'), 'class'=>'date')); ?></div></td>                
            </tr>
            <tr>
                <td><?php echo $this->Form->input('regional', array('label' => __('Regional'), 'options' => $regional, 'empty' => __('Todas'), 'onChange'=>'obtenerCiudades()')); ?></td>
                <td><div id="divCiudades"><?php echo $this->Form->input('ciudad', array('label' => __('Ciudad'), 'options' => $ciudad, 'empty' => __('Todas'), 'onChange'=>'obtenerOficinas()' )); ?></div></td>
                <td><div id="divOficinas"><?php echo $this->Form->input('oficina', array('label' => __('Oficina'), 'options' => $oficina, 'empty' => __('Todas'))); ?></div></td>
            </tr>
            <tr>  
                <td>&nbsp;</td>
                <td colspan="2"><?php echo $this->Form->submit('Generar Reporte',array('class'=>'btn btn-info')); ?></td>
            </tr>
        </table>
    </fieldset>
</div>