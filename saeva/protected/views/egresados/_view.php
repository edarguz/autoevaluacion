<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_egresados')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_egresados),array('view','id'=>$data->id_egresados)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->Nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Link')); ?>:</b>
	<?php echo CHtml::encode($data->Link); ?>
	<br />


</div>