<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_factor')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_factor),array('view','id'=>$data->id_factor)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_factor')); ?>:</b>
	<?php echo CHtml::encode($data->num_factor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ponderacion')); ?>:</b>
	<?php echo CHtml::encode($data->ponderacion); ?>
	<br />


</div>