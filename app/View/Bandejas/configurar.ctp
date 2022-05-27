<?php $this->layout = 'inicio';?>
<?php echo ($this->Html->script('flujos/configurar.js')); ?>
<script type="text/javascript">
    var urlBase = <?php echo json_encode(Router::url('/')); ?>;    
</script>
<fieldset>
        <legend><h2><?php echo __('Configuración de Flujo'); ?></h2></legend>
</fieldset>

<!--Se crea el div/dialog para asignar permisos por usuario y/o perfil-->
<div id="dialogoPermisos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>   
        <h3>Permisos Bandeja <span id="permisos_nombreBandeja"></span></h3>        
    </div>
    
    <div class='modal-body'>         

        <table class="table table-condensed" id="tablaPermisoUsuarioBandeja">
            <caption><h4>Permisos Actuales</h4></caption>
                  <thead>
                    <tr>
                    <th>Usuario</th>
                    <th>Permiso</th>
                    <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>                    
        </table>
        
        <ul class="nav nav-tabs" id='asignar_permisos'>
            <li class="active"><a href='#permiso_por_perfil_tab' data-toggle='tab'>Permisos por Perfil</a></li>
            <li><a href='#permiso_por_usuario_tab' data-toggle='tab'>Permisos por Usuario</a></li>
        </ul>          
                
        <div class="tab-content">
            <div class="tab-pane active" id="permiso_por_perfil_tab">
                <fieldset>
                    <legend><strong>Agregar Permiso</strong></legend>
                    <form class="form-horizontal">
                        <div class="alert alert-success" id="mensaje_respuesta_permiso_perfil" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>!Guardado con exito!</strong>
                        </div>                        
                        <div class="control-group">
                            <table class="table table-condensed" id="tablaPerfilPermisos">
                            <tr>
                                <th><?php echo 'Nombre Perfil' ?></th>			
                                <th class="actions"><?php echo __('Permisos'); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php foreach ($infoPerfiles as $perfiles): ?>
                            <tr>
                                <td><?php echo h($perfiles['Perfile']['descripcion']); ?>&nbsp;</td>
                                <td><?php echo $this->Form->input('Permisobandeja.0.id', array('options' => $listPermisoBandeja, 'id' => 'permisoperfilbandeja_'.$perfiles['Perfile']['id'], 'label' => false)); ?></td>
                                <td><input type="button" class="btn btn-primary" onclick="agregarPermisoPerfilBandeja(this);" value="Agregar" name="btnpp_<?php echo $perfiles['Perfile']['id']; ?>"></input></td>
                            </tr>
                            <?php endforeach; ?>
                            </table>
                        </div>      
                        
                    </form>                    
                </fieldset>
            </div>
            
            <div class="tab-pane" id="permiso_por_usuario_tab">
                <fieldset>
                    <legend><strong>Agregar Permiso</strong></legend>
                    <form class="form-horizontal">
                        <div class="alert alert-success" id="mensaje_respuesta_permiso_usuario" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>!Guardado con exito!</strong>
                        </div>                        
                        <div class="control-group">
                            <table class="table table-condensed" id="tablaPerfilPermisos">
                            <tr>
                                <th><?php echo 'Nombre Usuario' ?></th>			
                                <th class="actions"><?php echo __('Permisos'); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php foreach ($infoUsuarios as $usuarios): ?>
                            <tr>
                                <td><?php echo h($usuarios['Usuario']['nombre']); ?>&nbsp;</td>
                                <td><?php echo $this->Form->input('Permisobandeja.0.id', array('options' => $listPermisoBandeja, 'id' => 'permisousuariobandeja_'.$usuarios['Usuario']['id'], 'label' => false)); ?></td>
                                <td><input type="button" class="btn btn-primary" onclick="agregarPermisoUsuarioBandeja(this);" value="Agregar" name="btnpu_<?php echo $usuarios['Usuario']['id']; ?>"></input></td>
                            </tr>
                            <?php endforeach; ?>
                            </table>                        
                         </div>                        
                    </form>                                          
                </fieldset>                
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>    
</div>


<div id="addBandejaSecuencia" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Añadir Secuencia de Bandejas</h3>
  </div>
  <div class="modal-body">
        <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label" for="bandeja">Bandeja Inicial :</label>
              <div class="controls">

                <?php echo $this->Form->input('Bandejas.0.id', array('options' => $listBandejas, 'class' => 'select_bandeja', 'id' => 'bandeja_inicial', 'label' => false)); ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="bandeja">Bandeja Siguiente : </label>
              <div class="controls">

                <?php echo $this->Form->input('Bandejas.0.id', array('options' => $listBandejas, 'class' => 'select_bandeja', 'id' => 'bandeja_siguiente', 'label' => false)); ?>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="bandeja">Mensaje de Cambio :</label>
              <div class="controls">
                <?php echo $this->Form->input('Cambiobandejamensajes.0.id', array('options' => $listEtiquetasCambEst, 'class' => 'select_etiquetas', 'id' => 'bandeja_etiqueta', 'label' => false)); ?>
              </div>
            </div>
            
            <div>
                <div class="controls">
                    <input id="analisiscargas" type="checkbox" />
                    Análisis de Cargas
                </div>
            </div>
        </form>
  </div>
  <div class="modal-footer">
    <button class="btn" onclick="cerrarDialogoSecuencia()" aria-hidden="true">Cancelar</button>
    <button class="btn btn-primary" onclick="agregarSecuencia()">Guardar</button>
  </div>
</div>


<!--Se crean las tablas que muestran la información de las bandejas y la configuración del flujo-->
<div class="flujos form">
          <table class="table table-striped table-condensed">
          <caption><strong><h4>Bandejas</h4></strong></caption>

          <?php foreach($infoBandejas as $tupla){ ?>
              <tr id="bandejaflujo_<?php echo $tupla['Bandeja']['id']; ?>">
                  <td>
                    <?php if($tupla['Estado']['estadoinicial']){ ?>
                      <span class="label label-info">Inicial</span>
                    <?php
                    }
                    ?>

                    <?php if($tupla['Estado']['estadofinal']){ ?>
                      <span class="label label-success">Final</span>
                    <?php
                    }
                    ?>
                      
                    <?php if($tupla['Estado']['estadoanulado']){ ?>
                      <span class="label label-important">Rechazo</span>
                    <?php
                    }
                    ?>                      
                      
                 </td>
                 <td class="nombre_bandeja">
                  <?php echo $tupla['Bandeja']['descripcion'] . " (" . $tupla['Estado']['descripcion'] . ")"; ?>                
                 </td>                  
                 <td><a style="cursor: pointer;" onclick='abrirDialogoPermisos(
                  <?php 
                    echo $tupla['Bandeja']['id'];
                  ?>, 
                  <?php 
                    echo json_encode($tupla['Bandeja']['descripcion']);
                  ?>
                  );'> Permisos </a>
                  </td>              
              </tr>
          <?php
          }
          ?>
      </table>

    <!--Se valida si el usuario logueado tiene permisos para configurar el flujo-->
    <?php if(isset($arrPriviUsrGest['PrivilegiosUsuario']) && $arrPriviUsrGest['PrivilegiosUsuario']['privilegio_id'] == '5'){?>
      <table class="table table-striped table-condensed">
          <caption><strong><h4>Secuencias Flujo<h4></strong></caption>
          <?php 
          foreach($infoBandejasEstados as $idSecuencia => $datosFlujoSecuencia){  
          ?>
              <tr id="flujosecuencia_<?php echo $datosFlujoSecuencia['Bandejasestado']['id']; ?>">
                  <td>                    
                  <span><?php echo $datosFlujoSecuencia['Bandeja']['descripcion']; ?></span>
                  </td>
                  <td>
                  <span class="label label-info"><?php echo $datosFlujoSecuencia['Etiquetacambioestado']['descripcion']; ?></span>
                  </td>
                  <td>
                  <span><?php echo $datosFlujoSecuencia['Estado']['descripcion']; ?></span>
                  </td>
                  <td><a style="cursor: pointer;" onclick="borrarSecuencia(<?php 
                    echo $datosFlujoSecuencia['Bandejasestado']['id'];
                  ?>);"><i class="icon-trash"></i> Borrar</a><td>
              </tr>
          <?php
          }
          ?>
        </table>   
    <?php } ?>
</div>
<div class="actions">
    <ul>
        <li>            
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBandejaSecuencia">Añadir Secuencia de Bandeas</button>
        </li>
    </ul>
</div>
<br>