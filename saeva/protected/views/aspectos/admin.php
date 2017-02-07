<?php
/* @var $this AspectosController */
/* @var $model Aspectos */

$this->breadcrumbs=array(
	//'Aspectos'=>array('index'),
	'Administrar Aspectos',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Aspectos','url'=>array('admin'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;

});
$('.search-form form').submit(function(){
	$('#aspectos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('actualizar', "
$('.actualizar-form form').submit(function(){
    $('#aspectos-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
"); 

?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Administrar',
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
);?>		

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

<div class="container-fluid">

<div class="thumbnail">
  
	    <div class="lead" align="left/center/right/justify"> 
	    	<ul class="nav nav-pills nav-stacked disabled">
			  <li role="presentation" class="active"><a>Administrar Aspectos a evaluar</a></li>
			</ul>
	    </div>

	<div class="form-horizontal" align="top">
	<?php echo CHtml::beginForm(array('export')); ?>
	<select name="fileType" style="width:150px;">
		<option value="Excel5">EXCEL(xls)</option>
		<option value="Excel2007">EXCEL 2007 (xlsx)</option>
		<option value="PDF">PDF</option>
		
	</select>



<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Exportar a', 'type'=> 'primary'));
?>
<?php echo CHtml::endForm(); ?>

</div>



<div class="form-vertical">


<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'Link', 
	'icon'=>'fa fa-plus-circle',
	'url'=>'../aspectos/create', 
	'type'=> 'primary'
	));
?>

<?php echo CHtml::link('<i class="fa fa-search"></i>','#',array('class'=>'search-button btn btn-primary')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,


)); ?>

<br>

</div><!-- search-form -->
</div>

<br>
	<div class="alert alert-info" role="alert">
    
	    
	 <table class="table table-bordered">

	<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'type'=>'striped bordered condensed',



	'attributes'=>array(
		array('name' => 'programa.nombre', 'label' => 'Programa'),
		array('name' => 'factor.factor', 'label' => 'Factor'),
		array('name' => 'caracteristica.caracteristicas', 'label' => 'Caracteristica'),
		array('name' => 'caracteristica.detalle', 'label' => ''),	

           
	),
)); ?>

</table>
		
</div>

<div class="form-well">
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




<td>
<div class="grid-view rounded" id=aspectos-grid" >
<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
	'id'=>'aspectos-grid',
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'ajaxUpdate'=>false,
	'type' => 'striped bordered condensed',
	//'selectableRows'=>2, 
    'summaryText' => false,
    'cacheTTL' => 10, // cache will be stored 10 seconds (see cacheTTLType)
    'cacheTTLType' => 's', // type can be of seconds, minutes or hours
	'columns'=>array(
			// array(
		 //        'header' => 'Id_aspecto',
		 //        'name'=> 'id_aspecto',
		 //        'type'=>'raw',
		 //        'value' => '($data->id_aspecto)',
		 //        'class' => 'bootstrap.widgets.TbEditableColumn',
	  //           'headerHtmlOptions' => array('style' => 'text-align:center'),
				
		 //    ),
			
			// array(
		 //        'header' => 'Programa',
		 //        'name'=> 'tbl_Programa_id_programa',
		 //        'type'=>'raw',
		 //        'value' => '($data->tbl_Programa_id_programa)',
		 //        //'class' => 'bootstrap.widgets.TbEditableColumn',
	  //           'headerHtmlOptions' => array('style' => 'text-align:center'),
				
		 //    ),
			
			// array(
		 //        'header' => 'Factor',
		 //        'name'=> 'tbl_Factor_id_factor',
		 //        'type'=>'raw',
		 //        'value' => '($data->tbl_Factor_id_factor)',
		 //        //'class' => 'bootstrap.widgets.TbEditableColumn',
	  //           'headerHtmlOptions' => array('style' => 'text-align:center'),
			// 	// 'editable' => array(
			// 	// 	'type'    => 'textarea',
			// 	// 	'url'     => $this->createUrl('editable'),
			// 	// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
			// 	// )
		 //    ),
			
			// array(
		 //        'header' => 'Caracteristica',
		 //        'name'=> 'tbl_caracteristica_id_caracteristica',
		 //        'type'=>'raw',
		 //        'value' => '($data->tbl_caracteristica_id_caracteristica)',
		 //        //'class' => 'bootstrap.widgets.TbEditableColumn',
	  //           'headerHtmlOptions' => array('style' => 'text-align:center'),
			// 	// 'editable' => array(
			// 	// 	'type'    => 'textarea',
			// 	// 	'url'     => $this->createUrl('editable'),
			// 	// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
			// 	// )
		 //    ),
			
			array(
		        'header' => 'Nº',
		        'name'=> 'num_aspecto',
		        'type'=>'raw',
		        'value' => '($data->num_aspecto)',
		        //'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				// 'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
		    ),
			
			array(
		        'header' => 'Aspecto',
		        'name'=> 'aspecto',
		        'type'=>'raw',
		        'value' => '($data->aspecto)',
		        //'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span7'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				// 'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
		    ),
			

			array(
		        'header' => 'Instrumento',
		        'name'=> 'instrumento',
		        'type'=>'raw',
		        'value' => '($data->instrumento)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				'editable' => array(
					'type'    => 'select2',
					'url'     => $this->createUrl('editable'),
					'source'    => array(
						'Documento'=>'Documento',
				  		'Informacion'=>'Informacion',
				  		'Encuesta'=>'Encuesta',
				  		'Numero'=>'Numero',
				  		'Consulta'=>'Consulta',
						),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			


			array(
		        'header' => 'Fuente',
		        'name'=> 'fuente',
		        'type'=>'raw',
		        'value' => '($data->fuente)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				'editable' => array(
					'type'    => 'textarea',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			


			array(
		        'header' => 'Documento',
		        'name'=> 'documento',
		        'type'=>'raw',
		        'value' => '($data->documento)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				'editable' => array(
					'type'    => 'textarea',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			


			array(
		        'header' => 'Link',
		        'name'=> 'link',
		        'type'=>'raw',
		        //'value' => '($data->link)',
		        'value' => 'CHtml::link($data->link, $data->link, array("target"=>"_blank"))',
		       //'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span2'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
		       	'value'=>'CHtml::link("Link.Doc.", "$data->link" . Yii::app()->request->userHost . "", array("target"=>"_blank"))',
		       	//'value'=>'CHtml::link("Link Doc.", "http://" . $_SERVER["SERVER_NAME"] . Yii::app()->request->baseUrl .  $data->link)',
		        //'value'=> 'CHtml::link("<i class="fa fa-search"></i>",$data->link)',
		       // 'class'=>'CButtonColumn',
		       // 'template'=>'{update}',
				
		    ),
			


			array(
		        'header' => 'Observaciones',
		        'name'=> 'Observaciones',
		        'type'=>'raw',
		        'value' => '($data->Observaciones)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span4'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				'editable' => array(
					'type'    => 'textarea',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),

		    // array(
      //                   'class'=>'bootstrap.widgets.TbJsonCheckBoxColumn',
                         

            
      //       ),



			array(
		        'header' => 'cumple',
		        'name'=> 'cumple',
		        'type'=>'raw',
		        'value' => '($data->cumple)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span4'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				'editable' => array(
					'type'    => 'select',
					'url'     => $this->createUrl('editable'),
					//'source' => array('SI','NO'),
					'source'    => array('SI' => 'SI', 'NO' => 'NO'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),


			
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
  //               	'url' => '$data->id_aspecto."|".$data->id_aspecto',              
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

</div>
</td>

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
</div>