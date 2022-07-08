<?php 
    $this->layout = 'inicio'; 
    echo $this->Html->script('ubicaciones/ubicaciones.js');
?>

<div class="ubicaciones index"><br>

    <div class="container">
        <div class="left">
            <h2><?php echo __('Ubicaciones Físicas'); ?></h2>
        </div>
        <div class="right">
            <button type="button" class="btn btn-primary" onclick="nuevaUbicacion()">Nueva Ubicación</button>
        </div>
    </div>   

    <div style="margin-top: 20px;">
        <ul class="media-list">
            <li class="media">

                <div class="media-body">
                    <?php foreach ($ubicaciones as $val): ?>

                        <div class="media">
                            <div class="pull-left" id="folder_<?php echo ($val['Ubicacionesfisica']['id']); ?>" data-idpadre="<?php echo ($val['Ubicacionesfisica']['id']); ?>" style="cursor: pointer;" onclick="gestionSubmenus(this)">
                                <i class="fa fa-folder fa-2x" title="Ver" id="ifolder_<?php echo ($val['Ubicacionesfisica']['id']); ?>" style="color:#FFC300"></i>    
                            </div>
                            <div class="media-body">  
                                        <h5 class="media-heading">
                                            <span style="cursor: pointer;" title="Agregar" data-desc="<?php echo ($val['Ubicacionesfisica']['descripcion']); ?>" data-id="<?php echo ($val['Ubicacionesfisica']['id']); ?>" onclick="agregarUbicacion(this)"><?php echo ($val['Ubicacionesfisica']['descripcion']); ?></span>
                                            <span style="cursor: pointer; margin-left:10px;" title="Editar" data-id="<?php echo ($val['Ubicacionesfisica']['id']); ?>" onclick="editarUbicacion(this)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                                        </h5>
                                        
                                <div id="submenu_<?php echo ($val['Ubicacionesfisica']['id']); ?>"></div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </li>
        </ul>
    </div>
</div>
    
