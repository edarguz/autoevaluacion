<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_plan')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_plan),array('view','id'=>$data->id_plan)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_factor_id_factor')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_factor_id_factor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_responsable')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_responsable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cargo')); ?>:</b>
	<?php echo CHtml::encode($data->cargo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dependencia')); ?>:</b>
	<?php echo CHtml::encode($data->dependencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_inicio')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_fin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peso')); ?>:</b>
	<?php echo CHtml::encode($data->peso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indicador')); ?>:</b>
	<?php echo CHtml::encode($data->indicador); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta')); ?>:</b>
	<?php echo CHtml::encode($data->meta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recursos')); ?>:</b>
	<?php echo CHtml::encode($data->recursos); ?>
	<br />

	*/ ?>

</div>