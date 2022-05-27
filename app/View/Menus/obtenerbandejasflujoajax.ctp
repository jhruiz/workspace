<?php
$url_app = Router::url( '/', true );
?>
<?php if (count($bandejasusr)>'0'){?>
<ul>
    <?php
        foreach($bandejasusr as $cl => $vl){      
    ?>
            <li><a href="<?php echo "{$url_app}bandejas/listarpaquetes/{$vl["Bandeja"]["id"]}"?>"><?php echo $vl["Bandeja"]["descripcion"]; ?></a></li>
    <?php        
        }
    ?>        
</ul>
<?php } else {}?>