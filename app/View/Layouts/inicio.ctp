<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>Sistema de Gestión Documental</title>  
    <?php
  
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('StyleLayout', 'StyleTable'));
        echo $this->Html->css('bootstrap');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        echo $this->Html->script('jquery-1.10.2');
        echo $this->Html->script('bootstrap.min.js');
        echo $this->Html->script('jquery-ui/js/jquery-ui-1.10.3.custom.min');
        echo $this->Html->script('bootbox.min.js');
        echo $this->Html->css('jquery-ui-css/redmond/jquery-ui.css');
        echo $this->Html->css('font-awesome/css/font-awesome.min.css');

        /*Adicionamos la librería para el menu*/
        echo $this->Html->css('menu');
        echo $this->Html->script('menu.js?ver=1.0');
        
        /*Adicionamos librería para menu vertical*/
        echo $this->Html->script('menu_vert/jquery.easing.1.3');
        echo $this->Html->script('menu_vert/script_menu_vert');
        echo $this->Html->css('style_menu_vert');
        echo $this->Html->css('camposrotados');

        /*Adicionamos funciones para mostrar modal*/
        echo $this->Html->script('modalCargar');

        /*Adicionamos funciones utiles para html*/
        echo $this->Html->script('jquery_number/jquery.number');
        echo $this->Html->script('utilsjs/utilsElementosHTML');
        echo $this->Html->script('layout/inicio');
        ?>      
        <style type="text/css">
            label {
                float: left;
                width: 75px;
                display: block;
                clear: left;
                text-align: left;
                cursor: hand;
            }

            .buttonC { /* clase general */
              border: 1px solid #dedede;
              border-radius: 3px;
              color: #555;
              display: inline-block;
              font: bold 12px/12px HelveticaNeue, Arial;
              padding: 8px 19px;
              text-decoration: none;
            }

            .buttonC.white{
              background: #f5f5f5;
              border-color: #dedede #d8d8d8 #d3d3d3;
              box-shadow: 0 1px 1px #eaeaea, inset 0 1px 0 #fbfbfb;
              color: #555;
              text-shadow: 0 1px 0 #fff;
              background: -moz-linear-gradient(top,  #f9f9f9, #f0f0f0);
              background: -webkit-linear-gradient(top,  #f9f9f9, #f0f0f0);
              background: o-linear-gradient(top,  #f9f9f9, #f0f0f0);
              background: ms-linear-gradient(top,  #f9f9f9, #f0f0f0);
              background: linear-gradient(top,  #f9f9f9, #f0f0f0);
              filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#f0f0f0');
            }
            
            .left{
                float: left;
            }
            .right{
                float: right;
            }
            
            .wrap{
                text-align:center
            }
            .leftTras{
                float: left;
            }
            .rightTras{
                float: right;
            }
            .centerTras{
            text-align:left;
                margin:0 auto !important; 
                display:inline-block
            }     
            
        </style>

    </head>
    <body>
        <div id="container-fluid">
            <header>                        
            <?php if ($logged_in) { ?>
                <input type="hidden" id="user-id" value="<?php echo $current_user['id'] ?>" />
                <input type="hidden" id="tipoperfiluser_id" value="<?php echo $current_user['Perfile']['descripcion'] ?>" />                
                <div id="menu">
                    <ul class="menu" id='menuHorizontal'>
                        <?php                
                            echo $this->Form->input('url-menu', array('type' => 'hidden', 'id' => 'url-menu', 'value' => $this->Html->url('/', true)));
                            echo '<script> generarMenu('. $current_user['Perfile']['id'] .'); </script>';                        
                        ?>
                    </ul>
                </div>
            <?php } ?>
                
            </header>
            <section id="izquierda">
            <?php       	
            if($logged_in){                    
            ?>
                <div id='menu_vert'>
                    </br> </br>
                </div>

            <?php
            }
            ?>                 
            </section>
            <div class="container-fluid ">
                    <article>
                        <?php if ($flash = $this->Session->flash()) { ?>
                            <div class="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $flash ?>
                            </div>
                        <?php } ?>

                        <?php echo $this->fetch('content'); ?>
                    </article>
            </div>
            <div class="container-fluid">
<!--                <footer id="piePagina">
                </footer>-->
<footer class="page-footer font-small blue pt-4 mt-4">

    <!--Copyright-->
    <div class="footer-copyright py-3 text-center">
        © 2018 Copyright:
        <a href="#"> sgd.com </a>
    </div>
    <!--/.Copyright-->

</footer>
            </div>
        </div>
        <input type="hidden" id="url-proyecto" value="<?php echo $this->Html->url('/', true) ?>" />
        <div id="copyright" style="display: none;" >Copyright &copy; 2013 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
    </body>
</html>
