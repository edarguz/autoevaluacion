<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'planmejoramiento-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownList($model,'tbl_Factor_id_factor', CHtml::Listdata(Factor::model()->findAll(),'id_factor','factor'),array('prompt'=>'Seleccione...','class'=>'span5','maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'nombre_responsable',array('class'=>'span5','maxlength'=>40)); ?>
<?php echo $form->textFieldRow($model,'cargo',array('class'=>'span5','maxlength'=>30)); ?>
<?php echo $form->textFieldRow($model,'dependencia',array('class'=>'span5','maxlength'=>50)); ?>
<?php echo $form->textFieldRow($model,'telefono',array('class'=>'span5','maxlength'=>30)); ?>
<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>30)); ?>
<?php echo $form->textFieldRow($model,'nombre_actividad',array('class'=>'span5','maxlength'=>30)); ?>
<?php echo $form->datepickerRow($model,'fecha_inicio',
								array(
					                'options' => array(
					                    'language' => 'id',
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
<?php echo $form->datepickerRow($model,'fecha_fin',
								array(
					                'options' => array(
					                    'language' => 'id',
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
<?php echo $form->textFieldRow($model,'peso',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'indicador',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'meta',array('class'=>'span5','maxlength'=>30)); ?>
<?php echo $form->textAreaRow($model,'descripcion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
<?php echo $form->textFieldRow($model,'recursos',array('class'=>'span5','maxlength'=>60)); ?>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
