<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_plan',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'tbl_factor_id_factor',array('class'=>'span5','maxlength'=>10)); ?>

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
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
