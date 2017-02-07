<?php
/* @var $this CalifFactorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Calificar Factores',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Calificar Factor','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('calif-factor-grid', {
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
        'title' => 'Calificación de Factores' ,
        'headerIcon' => 'icon- fa fa-list-ol',
        'headerButtons' => array(
            // array(
            //     'class' => 'bootstrap.widgets.TbButtonGroup',
            //     'type' => 'inverse',
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


<div class="form-well">

	

	<br>	

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
	'id'=>'aspectos-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate'=>false,
	'type' => 'striped bordered condensed',
	'selectableRows'=>2, 
	'filter'=>$model,
	//'filter'=>$model,
    //'summaryText' => false,
    //'cacheTTL' => 10, // cache will be stored 10 seconds (see cacheTTLType)
    //'cacheTTLType' => 's', // type can be of seconds, minutes or hours
    'template' => "{items}\n{extendedSummary}",

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
			'title'=>'Factores',
			'chart' => array(
				// 'width' => '800' // default reflow
			)
		),
	),



    'columns'=>array(
		
		// array(
		// 	'header' => '#',
	 //        'name'=> 'id_calif_factor',
	 //        'type'=>'raw',
	 //        'value' => '($data->id_calif_factor)',
	 //        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	 //        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        
	 //    ),
		
		array(
			'header' => 'Programa',
	        'name'=> 'tbl_Programa_id_programa',
	        'value' => '($data->programa->nombre)',
	        'filter'=> $model->getMenuPrograma(),
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span4'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),

	    ),

	    array(
			'header' => 'Fecha',
		    'name'=> 'fecha',
		    'type'=>'raw',
		    'value' => '(date("d-M-Y",strtotime($data->fecha)))',
		    'headerHtmlOptions' => array('style' => 'width:100px;text-align:center;'),
	        'htmlOptions' => array('style' => 'text-align:center;'),
	        
	    ),


	    array(
	        'header' => 'Factor',
	        'name'=> 'tbl_Factor_id_factor',
	        'value' => '($data->tbl_Factor_id_factor)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'footer'=>'Total',
	    ),
		
				
	    array(
			'header' => 'Ponderacion',
	        'name'=> 'tbl_Factor_id_factor',
	        'value' => '($data->factor->ponderacion)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'class'=>'bootstrap.widgets.TbTotalSumColumn',
	       

	    ),
		
		array(
			'header' => 'calificacion',
	        'name'=> 'calificacion',
	        'value' => '($data->calificacion)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	   //      'class' => 'bootstrap.widgets.TbEditableColumn',
	   //      'editable' => array(
				// 	'type'    => 'text',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
	    ),

	  //   array(
			// 'header' => 'evaluacion',
	  //       'name'=> 'calificacion',
	  //       'value' => '($data->evaluacion)',
	  //       'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	  //       'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	  //   ),

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
	   //    'class' => 'bootstrap.widgets.TbEditableColumn',
	   //          	// 'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
	      ),

	    // array(
     //        'header' => Yii::t('ses', 'Editar'),
     //        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
     //        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
     //        'class' => 'bootstrap.widgets.TbJsonButtonColumn',
     //        'template' => '{view} {update}',
     //        	'buttons'=>array (
			  //       'update'=> array(
			  //       	 'options'=>array( 'class'=>'icon-edit','title'=>'Actualizar Aspecto'),

			  //       	),

			  //       'view'=>array(
			  //           'options'=>array( 'class'=>'icon-search','title'=>'Ver Aspecto' ),
			  //       ),
     //   		 ),

     //        ),
		
		//'evaluacion',

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
  //               	'url' => '$data->id_calif_factor."|".$data->id_calif_factor',              
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


    
 
<?php  $this->endWidget(); ?>
