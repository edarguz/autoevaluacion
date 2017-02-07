<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'calificacion-caracteristica-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
<div>
<?php echo $form->labelEx($model,'Programa'); ?>
<?php echo $form->dropDownList($model,'tbl_Programa_id_programa', CHtml::listData(Programa::model()->findAll(),'id_programa','nombre'), array('prompt'=>'Seleccione programa','class'=>'span7','maxlength'=>10)); ?>
</div>

<div>
		<?php
			$htmlOptions=array(
				'ajax'=>array(
					'type'=>'POST',
					'url'=>$this->createUrl('calificacionCaracteristica/Cargarcaracteristica'),
					'update'=>'#CalificacionCaracteristica_tbl_caracteristica_id_caracteristica'
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


<?php echo $form->labelEx($model,'Caracteristica'); ?>
<?php echo $form->dropDownList($model,'tbl_caracteristica_id_caracteristica', CHtml::listData(Caracteristica::model()->findAll(),'id_caracteristica','caracteristicas'), array('prompt'=>'Seleccione Caracteristica','class'=>'span7','maxlength'=>10)); ?><?php echo $form->datepickerRow($model,'fecha',
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
<?php echo $form->textFieldRow($model,'ponderacion',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'calificacion',array('class'=>'span5')); ?>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
