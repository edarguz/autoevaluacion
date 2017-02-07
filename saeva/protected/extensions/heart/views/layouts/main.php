<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
	<?php
	$assetsDir=Yii::getPathOfAlias('ext.heart.views.css');
	$assets=Yii::app()->assetManager->publish($assetsDir);
	$cs=Yii::app()->clientScript;
	$cs->registerCssFile($assets.'/main.css');
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>

<?php

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');


$this->widget('bootstrap.widgets.TbNavbar', array(
	'type'=>'inverse', // null or 'inverse'
    'brand'=>CHtml::encode(Yii::app()->name),
    'brandUrl'=>'#',
    'brand'=>'<img src ="' . Yii::app()->request->baseUrl . '/images/cmc.png" /> SAEVA',
    'collapse'=>true, // requires bootstrap-responsive.css
	'items'=>array(
		array(
			'class'=> 'bootstrap.widgets.TbMenu',
			'items'=> $menu,				
		),
		array(
			'class'=>'bootstrap.widgets.TbMenu',
			'htmlOptions'=>array('class'=>'pull-right'),
			'items'=>array(
				array('label'=>'Login', 'url'=>array('/site/login'), 'icon'=>'fa fa-unlock', 'visible'=>Yii::app()->user->isGuest),
				//'---',
				array('label'=>'', 'url'=>'#', 'icon'=>'fa fa-user', 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'icon'=>'fa fa-power-off',),
	
				)),
			),
		),
	),
));
?>



<div class="container" id="page">
	<?php 
	if(isset($this->breadcrumbs)){
		$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		    'links'=>$this->breadcrumbs,
		));
	}	
	?>
	<?php echo $content; ?>
	<div class="clearfix"></div>
</div><!-- page -->

<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
	'brand' => '<img src ="' . Yii::app()->request->baseUrl . '/images/cmc2.png" />' . ' ' . '<small>Copyright &copy; 2015 Institución Universitaria Colegio Mayor del Cauca.</small>'. ' ' . '<small style="color: #FBF995; font-size: 8pt" align="right">Powered by edarguz</small>',
	'fixed' => 'bottom',
	'type' => 'inverse',
	'brandUrl'=>'http://www.colmayorcauca.edu.co',
	

        
));
?>
</body>
</html>