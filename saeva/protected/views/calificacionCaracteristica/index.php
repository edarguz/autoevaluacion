<?php
/* @var $this CalificacionCaracteristicaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Calificación Caracteristicas',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Calificación Caracteristica','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('calificacion-caracteristica-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");

Yii::app()->clientScript->registerScript('refreshGridView', "
	// automatically refresh grid on 5 seconds
	//setInterval(\"$.fn.yiiGridView.update('calificacion-caracteristica-grid')\",5000);
");

?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Calificacion Caracteristicas' ,
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

		<br>

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
	'id'=>'calificacionCaracteristica-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped bordered condensed',
    'summaryText' => false,
    //'cacheTTL' => 10, // cache will be stored 10 seconds (see cacheTTLType)
    //'cacheTTLType' => 's', // type can be of seconds, minutes or hours
	'ajaxUpdate'=>false,
	'enablePagination'=>true,
	//'filter'=>$model,
	'responsiveTable' => true,
    'enableSorting'=>true,
	'selectableRows'=>1,
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
					'name' => 'Evaluación Caracteristica',
					'attribute' => 'evaluacion'
				),
				array(
					'name' => 'Logro Ideal',
					'attribute' => 'logroideal'
				),
				// array(
				// 	'name' => 'Relación Logro Ideal',
				// 	'attribute' => 'relacionlogro'
				// )
			),
			'xAxis' => array(
				'categories' => 'tbl_caracteristica_id_caracteristica',
			),
		),
		'config' => array(
			'title'=>array(
				'text' => 'Evaluación de Características',
				),

			'chart' => array(

				// 'width' => '800' // default reflow
			)
		),
	),
	
   	'columns'=>array(

		// array(
		// 	'header' => 'Nº',
	 //        'name'=> 'id_calif_caracteristica',
	 //        'value' => '($data->id_calif_caracteristica)',
	 //        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	 //        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	 //    ),

		array(
	        'header' => 'Fecha',
	        'name'=> 'fecha',
	        'type'=>'raw',
	        'value' => '(date("d-M-Y",strtotime($data->fecha)))',
	        'headerHtmlOptions' => array('style' => 'width:100px;text-align:center;'),
	    ),

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
			'header'=>'Factor',
	        'name'=> 'tbl_Factor_id_factor',
	        'value' => '($data->factor->id_factor)',
	        'filter'=> $model->getMenuFactor(),
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	    ),
		
		array(
			'header' => 'Caracteristica',
	        'name'=> 'tbl_caracteristica_id_caracteristica',
	        'value' => '($data->tbl_caracteristica_id_caracteristica)',
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'footer'=>'Total',
	    ),

	    array(
			'header' => 'Ponderacion',
	        'name'=> 'ponderacion',
	        'value' => '($data->ponderacion)',
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'class'=>'bootstrap.widgets.TbTotalSumColumn',
	    ),
				
		array(
			'header' => 'Calificacion',
	        'name'=> 'calificacion',
	        'value' => '($data->calificacion)',
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        
	   //      'class' => 'bootstrap.widgets.TbEditableColumn',
	   //      'editable' => array(
				// 	'type'    => 'text',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
	    ),	

	    array(
			'header' => 'Evaluacion (PxC)',
	        'name'=> 'evaluacion',
	        'value' => '($data->califiCaracteristica())',
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span2'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'class'=>'bootstrap.widgets.TbTotalSumColumn',
	    ),

	    array(
			'header' => 'Logro ideal(Px5)',
	        'name'=> 'logroideal',
	        'value' => '($data->califilogroideal())',
	        'type'=>'raw',
	        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span2'),
	        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	        'class'=>'bootstrap.widgets.TbTotalSumColumn',
	        //'class' => 'bootstrap.widgets.TbEditableColumn',
	    ),

	  //   array(
			// 'header' => 'Rel logro ideal (E/L)',
	  //       'name'=> 'relacionlogro',
	  //       'value' => '($data->califiRelalogroideal())',
	  //       'type'=>'raw',
	  //       'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span2'),
	  //       'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	  //       'class'=>'bootstrap.widgets.TbTotalSumColumn',
	  //       //'class' => 'bootstrap.widgets.TbEditableColumn',
	  //   ),
		
		// array(
  //           'header' => Yii::t('ses', 'Editar'),
  //           'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
  //           'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
  //           'class' => 'bootstrap.widgets.TbJsonButtonColumn',
  //           'template' => '{view} {update}',
  //           	'buttons'=>array (
		// 	        'update'=> array(
		// 	        	 'options'=>array( 'class'=>'icon-edit','title'=>'Actualizar Aspecto'),

		// 	        	),

		// 	        'view'=>array(
		// 	            'options'=>array( 'class'=>'icon-search','title'=>'Ver Aspecto' ),
		// 	        ),
  //      		 ),

  //           ),
		//'calificacion',
		//'evaluacion',
		//'logroideal',
		//'relacionlogro',

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
  //               	'url' => '$data->id_calif_caracteristica."|".$data->id_calif_caracteristica',              
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
