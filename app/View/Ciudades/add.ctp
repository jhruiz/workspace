<?php $this->layout = 'inicio'; ?>
<div class="form">
<?php echo $this->Form->create('Ciudade'); ?>
	<fieldset>
            <legend><h2><?php echo __('Agregar Ciudad'); ?></h2></legend>
                
                <table>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('descripcion',array('label' => 'Nombre'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('regionale_id',array('label' => 'Regional'));?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('estadoregistro_id',array('label' => 'Estado')); ?>
                        </td>
                    </tr>
                </table>                         
	</fieldset>
    <?php echo $this->Form->submit('Guardar',array('class'=>'btn btn-info'));?>
    </form>
</div>