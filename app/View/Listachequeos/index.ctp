<?php 
    $this->layout = 'inicio'; 
    echo $this->Html->script('listachequeos/listachequeos.js');
?>
<div class="listachequeos index">
    <div class="container">

        <div class="left">
            <h2><?php echo __('Lista Items de Chequeo'); ?></h2>
        </div>
        
        <div class="right">
            <button type="button" class="btn btn-primary" onclick="addListaChequeos()">Nuevo Item</button>
        </div>            
    
    </div>     

    <table class="table table-striped" style="width:60%;">
        <tr>
            <th><?php echo ('Nombre'); ?></th>
            <th class="actions"><?php echo __('Acciones'); ?></th>
        </tr>
        
        <?php foreach ($listCheck as $listachequeo): ?>
        <tr>
            <td><?php echo h($listachequeo['Listachequeo']['descripcion']); ?>&nbsp;</td>
            <td class="actions">
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o fa-lg')), array('action' => 'edit', $listachequeo['Listachequeo']['id']), array('escape' => false)) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>
