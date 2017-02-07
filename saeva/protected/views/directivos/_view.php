<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_directivos')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_directivos),array('view','id'=>$data->id_directivos)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nombre')); ?>:</b>
	<?php echo CHtml::encode($data->Nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Link')); ?>:</b>
	<?php echo CHtml::encode($data->Link); ?>
	<br />


</div>