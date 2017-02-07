<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<br>

		<?php echo $form->textFieldRow($model,'num_factor',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>128)); ?>

		

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'size'=>'large',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
