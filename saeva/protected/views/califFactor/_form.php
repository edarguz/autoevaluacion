<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'calif-factor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">los campos con <span class="required">*</span> son requiredos.</p>

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->labelEx($model,'Programa'); ?>
<?php echo $form->dropDownList($model,'tbl_Programa_id_programa', CHtml::listData(Programa::model()->findAll(),'id_programa','nombre'), array('prompt'=>'Seleccione programa','class'=>'span7','maxlength'=>10)); ?>
<?php echo $form->labelEx($model,'Factor'); ?>
<?php echo $form->dropDownList($model,'tbl_Factor_id_factor', CHtml::listData(Factor::model()->findAll(),'id_factor','factor'), array('prompt'=>'Seleccione factor','class'=>'span7','maxlength'=>10)); ?>

<?php echo $form->datepickerRow($model,'fecha',
								array(
					                'options' => array(
					                    'language' => 'es',
					                    'format' => 'yyyy-mm-dd', 
					                    'weekStart'=> 1,
					                    'autoclose'=>'true',
					                    'keyboardNavigation'=>true,
					                ), 
					            ),
					            array(
					                'prepend' => '<i class="icon-calendar"></i>'
					            )
			);; ?>
<?php echo $form->textFieldRow($model,'calificacion',array('class'=>'span5')); ?>



<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
