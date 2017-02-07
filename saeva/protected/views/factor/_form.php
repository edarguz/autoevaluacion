<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'factor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<br>

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'num_factor',array('class'=>'span1','maxlength'=>10)); ?>
<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'ponderacion',array('class'=>'span1')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'size'=>'large',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
</div>


<?php $this->endWidget(); ?>

