<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<br>
	<br>


		<?php echo $form->labelEx($model,'Seleccione Factor'); ?>

		<?php echo $form->dropDownList($model,'tbl_Factor_id_factor', CHtml::Listdata(Factor::model()->findAll(),'id_factor','factor'),array('prompt'=>'Seleccione...','class'=>'span5','maxlength'=>128)); ?>

		<?php echo $form->textFieldRow($model,'num_caracteristica',array('class'=>'span1','maxlength'=>10)); ?>

		

		

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Buscar',
			'size'=>'large',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
