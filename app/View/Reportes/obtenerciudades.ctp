<?php
    echo $this->Form->input('Reporte.ciudad', array( 'type' => 'select', 'label' => 'Ciudad', 'options' => $ciudad,'empty' => __('Todas'),
            'onChange' => 'obtenerOficinas();'
        ));
?>
