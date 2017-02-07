<?php
/* @var $this CalificacionCaracteristicaController */
/* @var $model CalificacionCaracteristica */

$this->breadcrumbs=array(
	'Calificacion Caracteristicas'=>array('admin'),
	$model->id_calif_caracteristica,
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');


$menu2=array(
	array('label'=>'Calificación','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

if(!isset($_GET['asModal'])){
?>
<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Calificación de caracteristicas #'.$model->id_calif_caracteristica,
        'headerIcon' => 'icon- fa fa-eye',
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

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-arrow-left',
	'url'=>'../CalificacionCaracteristica/admin', 
	'type'=> 'primary'
	));
?>


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-plus-circle',
	'url'=>'../CalificacionCaracteristica/create',
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
		'id_calif_caracteristica',
		//'tbl_caracteristica_id_caracteristica',
		//'tbl_Factor_id_factor',
		//'tbl_Programa_id_programa',

			array(
			'label'=>'Programa',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->programa->nombre))

			),

				
			array(
		        'name'=> 'fecha',
		        'type'=>'raw',
		        'language'=>'es',
		        'value' => date("l, d M Y",strtotime($model->fecha)),
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

			
		'ponderacion',	
		'calificacion',
		// 'evaluacion',
		// 'logroideal',
		// 'relacionlogro',
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