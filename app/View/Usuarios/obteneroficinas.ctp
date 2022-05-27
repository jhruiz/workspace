<?php
    $opciones=array(            
            'type' => 'select',
            'label' => 'Oficinas:',
            'name' => 'data[Oficina][Oficina]',            
            'id' => 'OficinaOficina',
            'options'=>$oficinas,
        );
    
    if($obtenerUsuarios==0){
        $opciones['multiple'] = 'multiple';
    }else{
        $opciones['onchange'] = 'obtenerUsuariosDeOficina();';
    }
    
    echo $this->Form->input('Oficina.id',
        $opciones
    );  
?> 