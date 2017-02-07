<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<br>
	
		
	<div class="form-actions">
		<?php echo $form->labelEx($model,'Programa'); ?>
		<?php echo $form->dropDownList($model,'tbl_Programa_id_programa',$model->getMenuPrograma(),array(
					//'prompt'=>'Seleccione Programa...',
					'class'=>'span5',
					'maxlength'=>10));?>
		<?php echo $form->error($model,'tbl_Programa_id_programa');?> 
		
		
		
		<div>
		<?php
			$htmlOptions=array(
				'ajax'=>array(
					'type'=>'POST',
					'url'=>$this->createUrl('aspectos/Cargarcaracteristica'),
					'update'=>'#Aspectos_tbl_caracteristica_id_caracteristica'
					),

					'prompt'=>'Seleccione factor...',
					'class'=>'span5',
					'maxlength'=>10



				);?>


			<?php echo $form->labelEx($model,'Factor');?>
			<?php echo $form->dropDownList($model,'tbl_Factor_id_factor',$model->getMenuFactor(),$htmlOptions,
				array(
					'prompt'=>'Seleccione Caracteristica...',
					'class'=>'span5',
					'maxlength'=>10
				));?>	
			<?php  echo $form->error($model,'tbl_Factor_id_factor'); ?>


		</div>
			

		<div>
			<?php echo $form->labelEx($model,'Caracteristica'); ?>
			<?php echo $form->dropDownList($model,'tbl_caracteristica_id_caracteristica', 
			CHtml::listData(Caracteristica::model()->findAll(),
			'id_caracteristica','caracteristicas'), 
				array(
					'prompt'=>'Seleccione...',
					'class'=>'span7',
					'maxlength'=>10)
					 ); ?>	
		<?php echo $form->error($model,'tbl_caracteristica_id_caracteristica'); ?>
		</div>

			
		<br>

		<?php echo $form->labelEx($model,'Instrumento'); ?>		
		<?php echo $form->dropDownList($model,'instrumento',
			array(
				
				 'Documento'=>'Documento',
				  'Informacion'=>'Informacion',
				  'Encuesta'=>'Encuesta',
				  'Numero'=>'Numero',
				  'Consulta'=>'Consulta',


			),
			array(
			'prompt'=>'Seleccione...',
			'placeholder'=>'Instrumento',
			)

			); ?>

		<?php echo $form->textFieldRow($model,'fuente',array('class'=>'span5','maxlength'=>128)); ?>

		<?php echo $form->textFieldRow($model,'documento',array('class'=>'span5','maxlength'=>128)); ?>

		
	</div>

	<div class="form-vertical">
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Buscar',
		)); ?>
	</div>
	</div>

<?php $this->endWidget(); ?>
