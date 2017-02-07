<?php
/* @var $this FactorController */
/* @var $model Factor */

$this->breadcrumbs=array(
	'Administar Factores',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Factor','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#factor-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Factores',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            // array(
            //     'class' => 'bootstrap.widgets.TbButtonGroup',
            //     'type' => 'inverse',
            //     // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //     'buttons' => $this->menu
            // ),
        ) 
    )
);?>		<?php $this->widget('bootstrap.widgets.TbAlert', array(
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
<br>


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-refresh',
	'url'=>'../factor/admin', 
	'type'=> 'primary'
	));
?>


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-plus-circle',
	'url'=>'../factor/create', 
	'type'=> 'primary'
	));
?>


<?php echo CHtml::link('<i class="fa fa-search"></i>','#',array('class'=>'search-button btn btn-primary')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo CHtml::beginForm(array('export')); ?>

<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
	'id'=>'factor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped bordered condensed',
    'summaryText' => false,
    'cacheTTL' => 10, // cache will be stored 10 seconds (see cacheTTLType)
    'cacheTTLType' => 's', // type can be of seconds, minutes or hours
	'ajaxUpdate'=>false,
	'enablePagination'=>true,
	'responsiveTable' => true,
    'enableSorting'=>true,
	'selectableRows'=>1,
	'columns'=>array(
			array(
		        'header' => 'Nº',
		        'name'=> 'num_factor',
		        'type'=>'raw',
		        'value' => '($data->num_factor)',
		        //'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center','class'=>'span1'),
	            'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				// 'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
		    ),
			
			array(
		        'header' => 'Nombre Factor',
		        'name'=> 'nombre',
		        'type'=>'raw',
		        'value' => '($data->nombre)',
		        //'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center','class'=>'span10'),
	            'footer'=>'Total Ponderación',
				// 'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
		    ),

		     array(
		        'header' => 'Ponderacion',
		        'name'=> 'ponderacion',
		        'type'=>'raw',
		        'value' => '($data->ponderacion)',
		        'class'=>'bootstrap.widgets.TbTotalSumColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center','class'=>'span1'),
	            'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	       		
		    ),
			
					   
			
		/*
		//Contoh
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => '($data->Level->name)',
	        // 'value' => '($data->status)?"on":"off"',
	    ),
	    */
	    array(
            'header' => Yii::t('ses', 'Editar'),
            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
            'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
            'class' => 'bootstrap.widgets.TbJsonButtonColumn',
            'template' => '{view}  {update}',
            	'buttons'=>array (
			        'update'=> array(
			        	 'options'=>array( 'class'=>'icon-edit','title'=>'Actualizar factor'),

			        	),

			        'view'=>array(
			            'options'=>array( 'class'=>'icon-search','title'=>'Ver factor' ),
			        ),
       		 ),

            ),
	),
)); ?>


 
    <br>


<?php echo CHtml::endForm(); ?>

	<br>
	

<?php $this->endWidget(); ?>
<?php  $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 id="myModalHeader">Modal header</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>
    </div>
 
    <div class="modal-footer">
        <?php  $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>
