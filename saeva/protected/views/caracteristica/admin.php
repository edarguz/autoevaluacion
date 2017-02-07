<?php
/* @var $this CaracteristicaController */
/* @var $model Caracteristica */

$this->breadcrumbs=array(
	//'Caracteristicas'=>array('admin'),
	'Caracteristicas',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Caracteristica','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#caracteristica-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Administrar Caracteristicas',
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

<?php echo CHtml::link('<i class="fa fa-search"></i>','#',array('class'=>'search-button btn btn-primary')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<br>
<br>

<div class="form-well">
	<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'type' => 'striped bordered condensed',
	'attributes'=>array(
		array('name' => 'factor.num_factor', 'label' => 'Numero factor'),
		array('name' => 'factor.nombre', 'label' => 'Factor'),
		

		
		
	),
)); ?>
</div>

<?php echo CHtml::beginForm(array('export')); ?>
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
			array(
		        'header' => 'Factor',
		        'name'=> 'tbl_Factor_id_factor',
		        'type'=>'raw',
		        'value' => '($data->tbl_Factor_id_factor)',
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
		        'header' => 'Nº',
		        'name'=> 'num_caracteristica',
		        'type'=>'raw',
		        'value' => '($data->num_caracteristica)',
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
		        'header' => 'Nombre caracteristica',
		        'name'=> 'caracteristica',
		        'type'=>'raw',
		        'value' => '($data->caracteristica)',
		        //'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center','class'=>'span4'),
	            'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				// 'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
		    ),
			
			array(
		        'header' => 'Detalle',
		        'name'=> 'detalle',
		        'type'=>'raw',
		        'value' => '($data->detalle)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center','class'=>'span9'),
	            'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				'editable' => array(
					'type'    => 'textarea',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
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
				        	 'options'=>array( 'class'=>'icon-edit','title'=>'Actualizar Aspecto'),

				        	),

				        'view'=>array(
				            'options'=>array( 'class'=>'icon-search','title'=>'Ver Aspecto' ),
				        ),
       		 ),

            ),

	 //    array(
		// 	'class'=>'bootstrap.widgets.TbButtonColumn',
		// 	'buttons'=>array
  //           (
  //               'view' => array
  //               (    
  //               	'url' => '$data->id_caracteristica."|".$data->id_caracteristica',              
  //               	'click' => 'function(){
  //               		data=$(this).attr("href").split("|")
  //               		$("#myModalHeader").html(data[1]);
	 //        			$("#myModalBody").load("'.$this->createUrl('view').'&id="+data[0]+"&asModal=true");
  //               		$("#myModal").modal();
  //               		return false;
  //               	}', 
  //               ),
  //           )
		// ),
	),
)); ?>

<select name="fileType" style="width:150px;">
	<option value="Excel5">EXCEL 5 (xls)</option>
	<option value="Excel2007">EXCEL 2007 (xlsx)</option>
	<option value="HTML">HTML</option>
	<option value="PDF">PDF</option>
	<option value="WORD">WORD (docx)</option>
</select>
<br>

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Exportar a', 'type'=> 'primary'));
?>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>

	<br>
	


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
