<?php
/* @var $this FactorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Factores',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Factor','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('factor-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");

Yii::app()->clientScript->registerScript('refreshGridView', "
	// automatically refresh grid on 5 seconds
	//setInterval(\"$.fn.yiiGridView.update('factor-grid')\",5000);
");

?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Factores' ,
        'headerIcon' => 'icon- fa fa-list-ol',
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
<?php /** $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); **/ ?>
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
		<br>

<?php echo CHtml::link('<i class="fa fa-search"></i>','#',array('class'=>'search-button btn btn-primary')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

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
	        'name'=> 'num_factor',
	        'value' => '($data->num_factor)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	    ),
		
		array(
	        'name'=> 'nombre',
	        'value' => '($data->nombre)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class','span8'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'footer'=>'Total',
	    ),
		
		array(
	        'name'=> 'ponderacion',
	        'value' => '($data->ponderacion)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class','span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'class'=>'bootstrap.widgets.TbTotalSumColumn',
	    ),
		

		/*
		//Contoh
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => '($data->Level->name)',
	        // 'value' => '($data->status)?"on":"off"',
	        // 'value' => '@Admin::model()->findByPk($data->createdBy)->username',
	    ),
	    */
		// array(
		// 	'class'=>'bootstrap.widgets.TbButtonColumn',
		// 	'template'=>'{view}',
		// 	'buttons'=>array
  //           (
  //               'view' => array
  //               (    
  //               	'url' => '$data->id_factor."|".$data->id_factor',              
  //               	'click' => 'function(){
  //               		data=$(this).attr("href").split("|")
  //               		$("#myModalHeader").html(data[1]);
	 //        			$("#myModalBody").load("'.$this->createUrl('view').'&id="+data[0]+"&asModal=true");
  //               		$("#myModal").modal();
  //               		return false;
  //               	}',
  //               ),
  //                           )
		// ),
	),
)); ?>

<br>


<?php echo CHtml::endForm(); ?>
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
                'label' => 'Cerrar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>
