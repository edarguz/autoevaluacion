<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre Factor')); ?>:</b>
	<?php echo CHtml::encode($data->factor->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_caracteristica')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_caracteristica),array('view','id'=>$data->id_caracteristica)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_caracteristica')); ?>:</b>
	<?php echo CHtml::encode($data->num_caracteristica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('caracteristica')); ?>:</b>
	<?php echo CHtml::encode($data->caracteristica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detalle')); ?>:</b>
	<?php echo CHtml::encode($data->detalle); ?>
	<br />

</div>