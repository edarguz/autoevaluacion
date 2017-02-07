<?php
/* @var $this SiteController */
/* @var $model Usuario */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Registrar usuario';
$this->breadcrumbs=array(
    'Registrar usuario',
);
?>
<h1><strong>Registrar nuevo usuario al sistema</strong></h1>

<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div class="'alert">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif ?>

<div class="progress">
    <div class="bar bar-inverse"  style="width: 100%;"></div>
</div>

<div class="form-horizontal well">
    <fieldset>
        

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="control-group">
            <?php echo $form->labelEx($model,'usuario', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'usuario'); ?>
                <?php echo $form->error($model,'usuario'); ?>
            </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model,'password', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
    </div>


    <div class="control-group">
             <div class="controls">
                 <?php echo CHtml::submitButton('Registrar Usuario',array('class'=>'btn btn-primary btn-large')); ?>
             </div>
    </div>


    <?php $this->endWidget(); ?>
    </div><!-- form -->

