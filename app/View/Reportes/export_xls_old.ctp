<style type="text/css">
    .tableTd {
        border-width: 0.5pt; 
        border: solid; 
        font-family: Arial,Verdana;
        font-size: 9px;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        width: 100px;
    }
    .tableTdContent{
        border-width: 0.5pt; 
        border: solid;
    }
    #titles{
        font-weight: bolder;
    }
    .textRotate{
        border-width: 0.5pt; 
        border: solid; 
        font-family: Arial,Verdana;
        font-size: 9px;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        border-width: 0.5pt; 
        border: solid; 
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
        mso-rotate: 90;
        -webkit-transform-origin: 50% 50%;
        -moz-transform-origin: 50% 50%;
        -ms-transform-origin: 50% 50%;
        -o-transform-origin: 50% 50%;
        transform-origin: 50% 50%;
        position: absolute;
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }
    .alineaIzquierda
    {
        text-align: left;
    }
</style>
<table>
    <?php
    if (!isset($paquetesFormato)) {
        ?>
        <tr>
            <td><b><?= $texto_tit; ?></b></td>
        </tr>
        <tr>
            <td><b>Fecha:</b></td>
            <td><?php echo date("d/m/Y, g:i a"); ?></td>
        </tr>
        <tr>
            <td><b>Numero de Filas:</b></td>
            <td class="alineaIzquierda"><?php echo count($rows); ?></td>
        </tr>
        <tr>
            <td></td>
        </tr>

        <tr id="titles">
            <?php foreach ($titulos as $i => $titulo): ?>
                <td class="tableTd" ><?php echo $titulo; ?></td>
            <?php endforeach; ?>
        </tr>
        <?php
    }
    else {
        ?>
        <tr><td><img src="file:///C:/wamp/www/workflow_mp/workflow/app/webroot/img/Logo_medicina_prepagada.png" alt="CakePHP" />
            <?php //echo $this->Html->image('Logo_medicina_prepagada.png', array('alt' => 'Logo mp')); ?></td></tr>
        <tr><td colspan="27"><center><b><?php echo __('REPORTE PRODUCCION'); ?></b></center></td></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td><b><?php echo __('FECHA: '); ?></b>&nbsp;</td>
        <td><b>Desde</b></td>
        <td><b>Hasta</b></td>    
    </tr>
    <tr>
        <td></td>
        <td class="alineaIzquierda"><?php echo h($desde); ?></td>
        <td class="alineaIzquierda"><?php echo h($hasta); ?></td>
    </tr>
    <tr>
        <td colspan='2'><b><?php echo __('CIUDAD QUE REMITE: '); ?></b>&nbsp;</td>
        <td colspan='2'><?php echo h($ciudad); ?></td>
    </tr>
    <tr>
        <td colspan='2'><b><?php echo __('NOMBRE DEL ASESOR: '); ?></b>&nbsp;</td>
        <td colspan='2'><?php echo h($usuario); ?></td>
    </tr>
    
    <tr></tr>
    <tr id="titles">
    <?php foreach ($titulos as $i => $titulo): ?>
            <td class='tableTd' ><?php echo $titulo; ?></td>
        <?php endforeach; ?>
        <?php foreach ($titulosrotados as $i => $titulo): ?>
            <td><div class="textRotate"><?php echo $titulo; ?><div></td>
        <?php endforeach; ?>                    
        <td class="tableTd" ><?php echo $titulodescripcion; ?></td>                    
    </tr>
    <?php
}
?>
<?php
if (isset($paquetes)) {
    foreach ($paquetes as $paquete):

        ?>
        <tr>
            <td class="tableTdContent" ><?php echo h($paquete['Paquete']['numerocredencial']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['Paquete']['numerosolicitud']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['Paquete']['fechacreacion']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['E']['descripcion']); ?></td>
            <td class="tableTdContent" >
                <?php if (isset($paquete['U']['nombre'])){
                    echo h($paquete['U']['nombre']); 
                }                     
                ?>
            </td>
            <td class="tableTdContent" ><?php echo h($paquete['R']['descripcion']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['C']['descripcion']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['O']['descripcion']); ?></td>
        </tr>
        <?php
    endforeach;
}else if (isset($trazas)) {
    foreach ($trazas as $traza):
        ?>
        <tr>
            <td class="tableTdContent"><?php echo h($traza['Paquete']['numerocredencial']); ?></td>
            <td class="tableTdContent"><?php echo h($traza['Paquete']['numerosolicitud']); ?></td>
            <td class="tableTdContent"><?php echo h($traza['Estado']['descripcion']); ?></td>
            <td class="tableTdContent"><?php echo h($traza['Usuario']['nombre']); ?></td>
            <td class="tableTdContent" ><?php echo h($traza['Paquete']['nombre_oficina']); ?></td>
            <td class="tableTdContent"><?php echo h($traza['Trazabilidade']['created']); ?></td>
            <td class="tableTdContent">                    <?php
                        $fecha = $traza['Trazabilidade']['created'];
                        $dias = (strtotime($fecha)-strtotime('now'))/86400;
                        $dias 	= abs($dias); 
                        $dias = floor($dias);
                        echo h($dias); 
                    ?></td>

        </tr>
        <?php
    endforeach;
}else if (isset($paquetesDias)) {
    foreach ($paquetesDias as $paquete):
        ?>
        <tr>                
            <td class="tableTdContent" ><?php echo h($paquete['P']['numerocredencial']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['P']['numerosolicitud']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['E']['descripcion']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['U']['nombre']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['Trazabilidade']['created']); ?></td>            
            <td class="tableTdContent" ><?php echo h($paquete['R']['descripcion']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['C']['descripcion']); ?></td>
            <td class="tableTdContent" ><?php echo h($paquete['O']['descripcion']); ?></td>
            <td class="tableTdContent" >
        <?php
                        $fechaActual = date("Y-m-d");
                        $fechaAnterior = strtotime(h($paquete['Trazabilidade']['created']));
                        $dias = (strtotime($fechaActual)-$fechaAnterior)/86400;
                        $dias = abs($dias); $dias = floor($dias);
                        echo $dias;
        ?>
            </td>
        </tr>
     <?php
            endforeach;
 }else if (isset($paquetesFormato)) {

     foreach ($paquetesFormato as $paquete): 
     ?>
        <tr>
            <td class="tableTdContent"><?php echo $paquete['Tipoproducto']['nombre']; ?></td>
            <td class="tableTdContent"><?php echo $paquete['Tipomovimiento']['nombre']; ?></td>
            <td class="tableTdContent"><?php echo $paquete['Paquete']['nombre_responsable']; ?></td>
            <td class="tableTdContent"><?php echo $paquete['Paquete']['cedula_responsable']; ?></td>
            <td class="tableTdContent"><?php echo $paquete['Paquete']['num_referencia']; ?></td>
            <td class="tableTdContent"><?php echo $paquete['Paquete']['placa']; ?></td>
            <?php
                $idsDocumentos = array('2','3','4','5','6','7','8','9','12','13','14','15','16','17','18','19','20','21','22','23');
                $documentosPaquete = $paquete['Documentospaquete'];
                foreach($idsDocumentos as $id):
                    $valor = false;
                    foreach($documentosPaquete as $paq => $paque)
                    {
                        if($id == $paque['documento_id'])
                        {
                            $valor = true;
                            break;
                        }
                    }

                    if($valor){
            ?>
                        <td class="tableTdContent">x</td>
                    <?php
                    }else{
                    ?>
                        <td class="tableTdContent"></td>
            <?php
                    }
                endforeach;
            ?>
                <td class="tableTdContent"></td>
        </tr>
    <?php
    endforeach;
}else if (isset($arrMotivosTraslado)) {

     foreach ($arrMotivosTraslado as $motTras): 
     ?>
        <tr>
            <td class="tableTdContent"><?php echo $motTras['PQ']['fechacreacion']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['PQ']['numerocredencial']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['PQ']['numerosolicitud']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['USU']['nombre']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['MotivostrasladosPaquete']['created']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['U']['nombre']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['MT']['descripcion']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['R']['descripcion']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['C']['descripcion']; ?></td>
            <td class="tableTdContent"><?php echo $motTras['O']['descripcion']; ?></td>
        </tr>
    <?php
    endforeach;
}
?>
</table>


