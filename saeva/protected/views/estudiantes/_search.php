<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_estudiantes',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'Nombre',array('class'=>'span5','maxlength'=>60)); ?>

		<?php echo $form->textFieldRow($model,'Link',array('class'=>'span5','maxlength'=>120)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
