<?php
$this->breadcrumbs=array(
	'Programas'=>array('admin'),
	$model->id_programa=>array('view','id'=>$model->id_programa),
	'Update',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Programa','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Actualizar Programa #'.$model->id_programa,
        'headerIcon' => 'icon- fa fa-pencil-square',
        'headerButtons' => array(
            // array(
            //     'class' => 'bootstrap.widgets.TbButtonGroup',
            //     'type' => 'success',
            //     // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //     'buttons' => $this->menu
            // ),
        ) 
    )
);?>

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-arrow-left',
	'url'=>'../admin', 
	'type'=> 'primary'
	));
?>


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-plus-circle',
	'url'=>'../programa/create', 
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
		?><?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<?php $this->endWidget(); ?>