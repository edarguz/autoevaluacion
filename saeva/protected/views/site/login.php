<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>



<div class="col-sm-6 col-md-4">
<div class="thumbnail">
<div class="form text-center">

   
    <div class="jumbotron">
    <div class="row">
        <p> <strong>Inicia sesión para acceder a SAEVA</strong> </p>

   

</div>


    </div>

         <div class="row">   
            <img src="../images/users2.png"  alt="Responsive image"/>
         </div>  

         <br> 
         <br>

                
         <div class="row">   
            <?php echo $form->textField($model,'username', array('style'=>'width:300px','placeholder'=>"Usuario", 'autofocus'=>'autofocus')); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>


          <div class="row"> 
            <?php echo $form->passwordField($model,'password', array('style'=>'width:300px','placeholder'=>"Contraseña")); ?>
            <?php echo $form->error($model,'password'); ?>
          </div>

        <div class="row">
            <?php echo CHtml::submitButton('Iniciar sesión',array('style'=>'width:310px','class'=>'btn btn-primary btn-large')); ?>
        </div>
    </div>
   </div>
  </div>
  
  



<?php $this->endWidget(); ?>
<!-- form -->




