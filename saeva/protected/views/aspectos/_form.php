<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'aspectos-form',
	'htmlOptions'=>array('class'=>'form-vertical'),
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>true),
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<fieldset>
 
		<legend>Aspectos a evaluar</legend>
		
  
	<br>

	<?php echo $form->errorSummary($model); ?>

	<div class="alert alert-info" role="alert">
    <div class="jumbotron" >
   		<?php echo $form->labelEx($model,'Programa'); ?>
		<?php echo $form->dropDownList($model,'tbl_Programa_id_programa', 
			CHtml::listData(Programa::model()->findAll(),
				'id_programa',
				'nombre'
				), array('prompt'=>'Seleccione...','class'=>'span7','maxlength'=>10)); ?>

		<?php echo $form->error($model,'tbl_Programa_id_programa'); ?>
		
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



		<div class="row">
			
        </div>

	
		<?php echo $form->textFieldRow($model,'num_aspecto',array('class'=>'span1','maxlength'=>20)); ?>
		<?php echo $form->textAreaRow($model,'aspecto',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
				
		<?php echo $form->textFieldRow($model,'instrumento',array('class'=>'span5','maxlength'=>60)); ?>
		
		<?php echo $form->textFieldRow($model,'fuente',array('class'=>'span5','maxlength'=>256)); ?>

		<?php echo $form->textFieldRow($model,'documento',array('class'=>'span5','maxlength'=>256)); ?>
		<?php echo $form->textFieldRow($model,'link',array('class'=>'span5','maxlength'=>256)); ?>
	    <?php echo $form->textAreaRow($model,'Observaciones',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	    
    
</div>
	</table>
	</div>
	</div>

<div class=”row”>




<div class="form-actions">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'size'=>'large',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>

</div>





<?php $this->endWidget(); ?>
