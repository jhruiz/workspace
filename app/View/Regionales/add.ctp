<?php $this->layout = 'inicio'; ?>
<div class="form">
    <?php echo $this->Form->create('Regionale'); ?>
    <fieldset>
        <legend><h2><?php echo __('Agregar Regional'); ?></h2></legend>
        <table>
            <tr><td colspan="3">
                    <?php echo $this->Form->input('descripcion',array('label' => "Nombre"));?>                    
                </td>
            </tr>
            <tr><td colspan="3">
                    <?php echo $this->Form->input('estadoregistro_id',array('label'=>'Estado'));?>
                </td>
            </tr>
        </table>
    </fieldset>
    <?php echo $this->Form->submit('Guardar',  array('class'=>'btn btn-info')); ?>
    </form>
</div>
