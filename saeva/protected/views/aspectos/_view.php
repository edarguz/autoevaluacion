<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_aspecto')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_aspecto),array('view','id'=>$data->id_aspecto)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_Programa_id_programa')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_Programa_id_programa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_Factor_id_factor')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_Factor_id_factor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_caracteristica_id_caracteristica')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_caracteristica_id_caracteristica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_aspecto')); ?>:</b>
	<?php echo CHtml::encode($data->num_aspecto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aspecto')); ?>:</b>
	<?php echo CHtml::encode($data->aspecto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrumento')); ?>:</b>
	<?php echo CHtml::encode($data->instrumento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fuente')); ?>:</b>
	<?php echo CHtml::encode($data->fuente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento')); ?>:</b>
	<?php echo CHtml::encode($data->documento); ?>
	<br />

	

	<b><?php echo CHtml::encode($data->getAttributeLabel('Observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->Observaciones); ?>
	<br />

	*/ ?>

</div>