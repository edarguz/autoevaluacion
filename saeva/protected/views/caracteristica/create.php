<?php
/* @var $this CaracteristicaController */
/* @var $model Caracteristica */

$this->breadcrumbs=array(
	//'Caracteristicas'=>array('index'),
	'Crear Caracteristica',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Caracteristica','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Crear Caracteristicas' ,
        'headerIcon' => 'icon- fa fa-plus-circle',
        'headerButtons' => array(
        	// array(
         //    	'class' => 'bootstrap.widgets.TbButtonGroup',
         //    	'type' => 'inverse',
         //    	// '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
         //    	'buttons' => $this->menu
         //    )
        )        
    )
);?>

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-arrow-left',
	'url'=>'../caracteristica/admin', 
	'type'=> 'primary'
	));
?>


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-plus-circle',
	'url'=>'../caracteristica/create', 
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
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget(); ?>