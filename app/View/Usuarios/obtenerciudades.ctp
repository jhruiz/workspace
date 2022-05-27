<?php
    echo $this->Form->input('Ciudade.id',
        array(
            'type' => 'select',
            'label' => 'Ciudad:',
            'options' => $ciudades,
            'onChange' => 'obteneroficinas();'
        )
    );  
?> 
