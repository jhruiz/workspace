<?php echo $this->Html->css('datepicker'); ?>
<?php echo ($this->Html->script('bandeja/gestionBandejas.js'));  ?>
<?php echo ($this->Html->script('reportes/estadopaquetes.js')); ?> 
<?php $this->layout = 'inicio'; ?>
<div class="diasenespera form">
<?php echo $this->Form->create('Solicitudreporte',array('controller' => 'solicitudreportes','action'=>'generarReporteCargasEjecutivo')); ?>
    <fieldset>
        <legend><h3><br /><?php echo __('Generador de Reportes - Cargas de Trabajo Ejecutivo'); ?></h3></legend>
        <br />
        <table width="100%">
            <tr>
                <td>
                    <div><?php echo $this->Form->input('usuario', array('label' => __('Usuario Ejecutivo'), 'options' => $usuarioEjecutivo, 'empty' => __('Todos'))); ?></div>
                    <?php echo $this->Form->input('tiporeporte', array('type' => 'hidden', 'value' => '3'));?>
                </td>
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
                <td colspan="2"><input type="button" class="btn btn-info" name="Generar Reporte" id="generarReporte" value="Generar Reporte" onclick="validacionReporte(this.form)"></td>                
            </tr>
        </table>
    </fieldset>
</div>
<div class="actions">
    <legend><h3><?php echo __('Acciones'); ?></h3></legend>
	<ul>
		<li><?php echo $this->Html->link(__('Ver Solicitudes de Reporte'), array('action' => 'listacargastrabajoejecutivo', '3')); ?></li>				
	</ul>
</div>