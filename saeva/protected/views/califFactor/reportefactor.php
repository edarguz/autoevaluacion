<?php
/* @var $this CalifFactorController */
/* @var $model CalifFactor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'calif-factor-califFactor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<h1>Flot</h1>
<?php
// lines and bars in same graph
 
$this->widget('application.extensions.EFlot.EFlotGraphWidget',
    array(
        'data'=>array(
            array(
                'label'=> 'line',
                'data'=>array(
                    array(1,1),
                    array(2,7),
                    array(3,12),
                    array(4,32),
                    array(5,62),
                    array(6,89),
                ),
                'lines'=>array('show'=>true),
                'points'=>array('show'=>true),
            ),
            array(
                'label'=> 'bars',
                'data'=>array(
                    array(1,12),
                    array(2,16),
                    array(3,89),
                    array(4,44),
                    array(5,38),
                ),
                'bars'=>array('show'=>true),
            ),
        ),
        'options'=>array(
                'legend'=>array(
                    'position'=>'nw',
                    'show'=>true,
                    'margin'=>10,
                    'backgroundOpacity'=> 0.5
                    ),
        ),
        'htmlOptions'=>array(
               'style'=>'width:400px;height:400px;'
        )
    )
);
?>
 
//Pie chart example
 
<?php
$format_func = <<<EOD
js:function(label, series){
    return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';}
EOD;
$this->widget('application.extensions.EFlot.EFlotGraphWidget',
    array(
        'data'=>array(
            array('label'=>'cows', 'data'=>20),
            array('label'=>'sheep', 'data'=>20),
            array('label'=>'chickens', 'data'=>30),
        ),
        'options'=>array(
            'series'=> array('pie'=>array(
                'show'=>true,
                'radius'=> 3/4,
                'formatter'=> $format_func,
                ),
            ),
            'legend'=> array('show'=>false),
        ),
        'htmlOptions'=>array('style'=>'width:400px;height:400px;')
    )
);
?>


<?php $this->endWidget(); ?>

</div><!-- form -->