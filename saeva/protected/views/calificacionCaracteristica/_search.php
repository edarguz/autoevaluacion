<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<br>
<br>



		<div>
		<?php echo $form->labelEx($model,'Programa'); ?>
		<?php echo $form->dropDownList($model,'tbl_Programa_id_programa',$model->getMenuPrograma(),array(
					//'prompt'=>'Seleccione Programa...',
					'class'=>'span5',
					'maxlength'=>10));?>
		<?php echo $form->error($model,'tbl_Programa_id_programa');?> 
		
		</div>

	

		<div>
		<?php echo $form->labelEx($model,'Factor'); ?>
		<?php echo $form->dropDownList($model,'tbl_Factor_id_factor', CHtml::listData(Factor::model()->findAll(),'id_factor','factor'), array('prompt'=>'Seleccione Factor','class'=>'span7','maxlength'=>10)); ?>
		<?php echo $form->error($model,'tbl_Factor_id_factor'); ?>
		</div>
		
		

		

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
