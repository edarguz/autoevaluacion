<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'usuario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'usuario',
	array(
		'class'=>'span5',
		'maxlength'=>30
		)); ?>
<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>60)); ?>
<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>60)); ?>
<?php echo $form->labelEx($model,'role'); ?>		
<?php echo $form->dropDownList($model,'role',
		array(
			'admin'=>'admin',
			'FCSA'=>'FCSA',
			'Ingenieria'=>'Ingenieria',
			'Arte'=>'Arte',
		),

		array(
			'prompt'=>'Seleccione rol...',
			'placeholder'=>'Role',
			)); ?>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
