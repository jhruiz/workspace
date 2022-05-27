<?php echo ($this->Html->script('reportes/tiempospromedio')); ?> 
<?php $this->layout = 'inicio'; ?>
<div class="tiempospromedio form">
    <?php echo $this->Form->create('Reporte',array( 'controller' => 'reportes','action'=>'generar_tiempospromedio')); ?>
    <fieldset>
        <legend><h2><?php echo __('Generador de Reportes - Consolidado'); ?></h2></legend>
        <table width="100%">
            <tr>
                <td><?php echo $this->Form->input('proceso', array('label' => __('Credencial'), 'options' => array('0'=>'Todos', '1' => 'Credencial'), 'onChange'=>'mostrarCampoAdmision()')); ?></td>
                <td><div id="divreferencia"><?php echo $this->Form->input('credencial', array('label' => __('No. Credencial'))); ?></div></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('tipo', array('label' => __('Visualizar en'), 'options' => array('0'=>'Pantalla', '1' => 'Excel'))); ?></td>
                <td><?php echo $this->Form->submit('Generar Reporte',array('class'=>'btn btn-info')); ?></td>
            </tr>
        </table>
    </fieldset>
</div>