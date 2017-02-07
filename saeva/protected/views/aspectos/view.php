<?php
/* @var $this AspectosController */
/* @var $model Aspectos */

$this->breadcrumbs=array(
	'Aspectos'=>array('admin'),
	$model->id_aspecto,
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');


$menu2=array(
	array('label'=>'Aspectos','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);



if(!isset($_GET['asModal'])){
?>
<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Aspecto a evaluar #'.$model->id_aspecto,
        'headerIcon' => 'icon- fa fa-pencil-square-o',
        'headerButtons' => array(
            // array(
            //     'class' => 'bootstrap.widgets.TbButtonGroup',
            //     'type' => 'inverse',
            //     // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //     'buttons' => $menu2
            // ),
        ) 
    )
);?>
<?php
}
?>



		<?php $this->widget('bootstrap.widgets.TbAlert', array(
		    'block'=>false, // display a larger alert block?
		    'fade'=>true, // use transitions?
		    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
		        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		    ),
		));
		?>		

		<div class="form">

		

		<?php 
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'Link', 
			'icon'=>'fa fa-reply',
			'url'=>'../aspectos/admin', 
			'type'=> 'primary'
			));
		?>

		<?php 
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'Link', 
			'icon'=>'fa fa-plus-circle',
			'url'=>'../aspectos/create', 
			'type'=> 'primary'
			));
		?>

		<br>
		<br>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(

		array(
			'header'=>'Programa',
			//'label'=>'Programa',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->programa->nombre))

			),
		
		array(
			'label'=>'Factor',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->factor->factor))

			),

		array(
			'label'=>'Caracteristica',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->caracteristica->caracteristicas))

			),

		array(
			'label'=>'',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->caracteristica->detalle))

			),

						
		'num_aspecto',
		'aspecto',
		'instrumento',
		'fuente',
		'documento',
		'link',
		'Observaciones',
		/*
		//CONTOH
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => ($model->Level->name),
	        // 'value' => ($model->status)?"on":"off",
	        // 'value' => @Admin::model()->findByPk($model->createdBy)->username,
	    ),

	    */
	),
)); ?>

<?php
if(!isset($_GET['asModal'])){
	$this->endWidget();}
?>