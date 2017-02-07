<?php
/* @var $this UsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuarios',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Usuario','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('usuario-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");

Yii::app()->clientScript->registerScript('refreshGridView', "
	// automatically refresh grid on 5 seconds
	//setInterval(\"$.fn.yiiGridView.update('usuario-grid')\",5000);
");

?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Usuarios SAEVA' ,
        'headerIcon' => 'icon- fa fa-list-ol',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'inverse',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
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


<?php echo CHtml::link('<i class="fa fa-search"></i>','#',array('class'=>'search-button btn btn-primary')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
	'id'=>'aspectos-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate'=>false,
	'type' => 'striped bordered condensed',
	'selectableRows'=>2, 
    'summaryText' => false,
    'cacheTTL' => 10, // cache will be stored 10 seconds (see cacheTTLType)
    'cacheTTLType' => 's', // type can be of seconds, minutes or hours
	'columns'=>array(
		array('header'=>'No','value'=>'($this->grid->dataProvider->pagination->currentPage*
					 $this->grid->dataProvider->pagination->pageSize
					)+
					array_search($data,$this->grid->dataProvider->getData())+1',
				'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	       	    'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        
		),
		array(
	        'name'=> 'usuario',
	        'value' => '($data->usuario)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	       	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        
	    ),
		
		//'password',
		array(
	        'name'=> 'role',
	        'value' => '($data->role)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
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
  //               	'url' => '$data->id."|".$data->usuario',              
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
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>
