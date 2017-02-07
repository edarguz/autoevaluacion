<?php
/* @var $this CalifFactorController */
/* @var $model CalifFactor */

$this->breadcrumbs=array(
	'Calificación de Factores'=>array('admin'),
	$model->id_calif_factor,
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');


$menu2=array(
	array('label'=>'CalifFactor','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

if(!isset($_GET['asModal'])){
?>
<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Calificación de factores #'.$model->id_calif_factor,
        'headerIcon' => 'icon- fa fa-eye',
        'headerButtons' => array(
            // array(
            //     'class' => 'bootstrap.widgets.TbButtonGroup',
            //     'type' => 'success',
            //     // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //     'buttons' => $menu2
            // ),
        ) 
    )
);?>
<?php
}
?>

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-arrow-left',
	'url'=>'../califFactor/admin', 
	'type'=> 'primary'
	));
?>

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-plus-circle',
	'url'=>'../califFactor/create', 
	'type'=> 'primary'
	));
?>
<br>
<br>

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
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'id_calif_factor',
		array(
			'label'=>'Programa',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->programa->nombre))

			),
		array(
			'label'=>'Factor',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->factor->factor))

			),
		
			array(
		        'name'=> 'fecha',
		        'type'=>'raw',
		        'value' => date("l, d M Y",strtotime($model->fecha)),
		    ),
			
					
		    array(
			'label'=>'Ponderacion',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->factor->ponderacion))

			),

			array(
			'label'=>'Calificacion',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->calificacion))

			),

			array(
			'label'=>'Evaluacion',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->evaluacion))

			),
			
		
		
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