<?php
/* @var $this CalifFactorController */
/* @var $model CalifFactor */

$this->breadcrumbs=array(
	//'Calif Factors'=>array('admin'),
	'Administración de factores',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Calificación','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#calif-factor-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('refreshGridView', "
	// automatically refresh grid on 5 seconds
	//setInterval(\"$.fn.yiiGridView.update('calif-factor-grid')\",5000);
");
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Administración',
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

<div class="thumbnail">
  
	    <div class="lead" align="left/center/right/justify"> 
	    	<ul class="nav nav-pills nav-stacked disabled">
			  <li role="presentation" class="active"><a>Calificación de Factores</a></li>
			</ul>
	    </div>

	<div class="form-horizontal" align="top">
	<?php echo CHtml::beginForm(array('export')); ?>
	<select name="fileType" style="width:150px;">
		<option value="Excel5">EXCEL 5 (xls)</option>
		<option value="Excel2010">EXCEL 2010 (xlsx)</option>
		<option value="PDF">PDF</option>
		<option value="WORD">WORD (docx)</option>
	</select>


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Exportar a', 'type'=> 'primary'));
?>
<?php echo CHtml::endForm(); ?>


</div>

<div class="form-well">


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-plus-circle',
	'url'=>'../califFactor/create', 
	'type'=> 'primary'
	));
?>

</div>


<div class="form-well">
    
	    <div class="jumbotron">
	    <table class="table table-hover" align="center">

	    <tr class="warning">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'type'=>'striped bordered condensed',


		'attributes'=>array(
			array('name' => 'programa.nombre', 'label' => 'Programa'),
			array('name' => 'factor.factor', 'label' => 'Factor'),
				           
			),
		)); ?>
		</tr>
		</table>
		</div>

</div>

<div class="form-well" align="rigth"> 

<?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
    )); ?>

    <div class="form" style="display: none">
        <?php echo $form->label($model,'tbl_Programa_id_programa'); ?>
        <?php echo $form->textField($model,'tbl_Programa_id_programa'); ?>
  </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'fa fa-refresh',
		)); ?>

	<?php $this->endWidget(); ?>

</div>


<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'califFactor-grid',
	'dataProvider'=>$model->search(),
	'template' => "{items}\n{extendedSummary}",
	'ajaxUpdate'=>false,
	'type' => 'striped bordered condensed',
	'selectableRows'=>2, 
	'filter'=>$model,
    //'summaryText' => false,
    //'cacheTTL' => 10, // cache will be stored 10 seconds (see cacheTTLType)
    //'cacheTTLType' => 's', // type can be of seconds, minutes or hours

    'extendedSummary' => array(
        'title' => 'Evaluación',
        'columns' => array(
            'evaluacion' => array('label'=>'Total evaluación', 'class'=>'TbSumOperation')
        )
    ),
    'extendedSummaryOptions' => array(
        'class' => 'well pull-right',
        'style' => 'width:300px'
    ),

    'chartOptions' => array(
		'defaultView' => true,
		'data' => array(
			'series' => array(
				array(
					'name' => 'Total Evaluación',
					'attribute' => 'evaluacion'
				)
			),
			'xAxis' => array(
				'categories' => 'tbl_Factor_id_factor',
			),
		),
		'config' => array(
			'title'=>array(
				'text' => 'Evaluación de Factores',
				),

			'chart' => array(

				// 'width' => '800' // default reflow
			)
		),
	),

	'columns'=>array(
			// array(
		 //        'header' => 'Id_calif_factor',
		 //        'name'=> 'id_calif_factor',
		 //        'type'=>'raw',
		 //        'value' => '($data->id_calif_factor)',
		 //        'class' => 'bootstrap.widgets.TbEditableColumn',
	  //           'headerHtmlOptions' => array('style' => 'text-align:center'),
			// 	'editable' => array(
			// 		'type'    => 'textarea',
			// 		'url'     => $this->createUrl('editable'),
			// 		'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
			// 	)
		 //    ),
			
		array(
		    'header' => 'Programa',
	        'name'=> 'tbl_Programa_id_programa',
	        'value' => '($data->programa->nombre)',
	        'filter'=> CHtml::listData(Programa::model()->findAll(),'id_programa','nombre'),
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
		  //       'class' => 'bootstrap.widgets.TbEditableColumn',
	   //          'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
		    ),

		    array(
		        'header' => 'Fecha',
		        'name'=> 'fecha',
		        'type'=>'raw',
		        'value' => '(date("d-M-Y",strtotime($data->fecha)))',
		        //'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:100px;text-align:center;'),
	            'htmlOptions' => array('style' => 'text-align:center;'),
				// 'editable' => array(
				// 	'type'          => 'date',
				// 	'format'		=> 'yyyy-mm-dd', //sent to server
    //               	'viewformat'    => 'dd-M-yyyy', //view user
				// 	'url'     => $this->createUrl('editable'),
				// 	'placement'     => 'right',
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
				
		    ),
			
			array(
		    'header' => 'Factor',
	        'name'=> 'tbl_Factor_id_factor',
	        'value' => '($data->tbl_Factor_id_factor)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
		  //       'class' => 'bootstrap.widgets.TbEditableColumn',
	   //          'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
	        'footer'=>'Total',
		    ),
			
			
			
			array(
		        'header' => 'Ponderacion',
		        'name'=> 'tbl_Factor_id_factor',
		        'value' => '($data->factor->ponderacion)',
		        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
		        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
		        'class'=>'bootstrap.widgets.TbTotalSumColumn',
		        // 'class' => 'bootstrap.widgets.TbEditableColumn',
		   //      'editable' => array(
					// 	'type'    => 'text',
					// 	'url'     => $this->createUrl('editable'),
					// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
					// )
		    ),


			array(
		        'header' => 'calificacion',
		        'name'=> 'calificacion',
		        'value' => '($data->calificacion)',
		        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
		        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
		        'class' => 'bootstrap.widgets.TbEditableColumn',
		        'editable' => array(
						'type'    => 'text',
						'url'     => $this->createUrl('editable'),
						'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
					)
		    ),
			
			array(
				  'header' => 'evaluacion',
			      'name'=> 'evaluacion',
			      'value' => '($data->calififactor())',
			      'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
			      'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
			      'class'=>'bootstrap.widgets.TbTotalSumColumn',
		      ),


			array(
			  'header' => 'Analisis cualitativo Ponderación',
		      'name'=> 'analisis_cualitativo',
		      'value' => '($data->analisis_cualitativo)',
		      'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span6'),
		      'htmlOptions'=>array('style' => 'width:100px;text-align:center;'),
		      'class' => 'bootstrap.widgets.TbEditableColumn',
		            'headerHtmlOptions' => array('style' => 'text-align:center'),
					'editable' => array(
						'type'    => 'textarea',
						'url'     => $this->createUrl('editable'),
						'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
					)
	      ),

		array(
			'header' => Yii::t('ses', 'Editar'),
			'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
            'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update}',
            'buttons'=>array (
				'update'=> array(
			       	 'options'=>array( 'class'=>'icon-edit','title'=>'Actualizar Calificación'),

			        	),

			        'view'=>array(
			            'options'=>array( 'class'=>'icon-search','title'=>'Ver Calificación' ),
			        ),
       		 ),

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
	 //    array(
		// 	'class'=>'bootstrap.widgets.TbButtonColumn',
		// 	'buttons'=>array
  //           (
  //               'view' => array
  //               (    
  //               	'url' => '$data->id_calif_factor."|".$data->id_calif_factor',              
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
