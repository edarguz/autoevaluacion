<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_programa')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_programa),array('view','id'=>$data->id_programa)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />


</div>