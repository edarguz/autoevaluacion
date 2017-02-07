<?php
$this->breadcrumbs=array(
	'Admin'=>array('index'),
);?>
<h1> Administración de backup</h1>

<?php $this->renderPartial('_list', array(
		'dataProvider'=>$dataProvider,
));
?>
