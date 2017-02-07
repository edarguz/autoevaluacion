<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_calif_caracteristica')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_calif_caracteristica),array('view','id'=>$data->id_calif_caracteristica)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_caracteristica_id_caracteristica')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_caracteristica_id_caracteristica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_Factor_id_factor')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_Factor_id_factor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_Programa_id_programa')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_Programa_id_programa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('calificacion')); ?>:</b>
	<?php echo CHtml::encode($data->calificacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('evaluacion')); ?>:</b>
	<?php echo CHtml::encode($data->evaluacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('logroideal')); ?>:</b>
	<?php echo CHtml::encode($data->logroideal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('relacionlogro')); ?>:</b>
	<?php echo CHtml::encode($data->relacionlogro); ?>
	<br />

	*/ ?>

</div>