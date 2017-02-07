<?php
/* @var $this AspectosController */
/* @var $model Aspectos */

// echo yii::app()->user->id;
// if (yii::app()->user->checkAccess("admin"))  {

// echo "role asignado a usuario";

// }

	
			

$this->breadcrumbs=array(
	'Aspectos',
			
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Aspectos','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
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
        'title' => 'Sistema de Autoevaluación',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'inverse',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                //'buttons' => $this->menu
            ),
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

<div class="lead" align="left"> 
	<?php echo CHtml::link('<i class="fa fa-search"></i>','#',array('class'=>'search-button btn btn-primary')); ?>
		<div class="search-form" style="display:none">
		<?php $this->renderPartial('_search',array(
		'model'=>$model,
		)); ?>
		</div><!-- search-form -->
			
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
			array('name' => 'caracteristica.caracteristicas', 'label' => 'Caracteristica'),
			array('name' => 'caracteristica.detalle', 'label' => ''),		
		           
			),
		)); ?>
		</tr>
		</table>
		</div>



</div>
<br>

 <div class="lead" align="left"> 

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

<div class="thumbnail">
   
	    <div class="lead" > 
	    	<ul class="nav nav-pills nav-stacked disabled" >
			  <li role="presentation" class="active" ><a>Aspectos a evaluar</a></li>
		</ul>
</div>

    

<?php $this->widget('bootstrap.widgets.TbJsonGridView',array(
	'id'=>'aspectos-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate'=>false,
	'type' => 'striped bordered condensed',
	'selectableRows'=>2, 
    'summaryText' => false,
    'cacheTTL' => 10, // cache will be stored 10 seconds (see cacheTTLType)
    'cacheTTLType' => 's', // type can be of seconds, minutes or hours
	'enablePagination'=>true,
	//'filter'=>$model,
	'selectableRows'=>1,

    //'selectionChanged'=>'userClicks',
   	'columns'=>array(
		// array(
	 //        'name'=> 'id_aspecto',
	 //        'value' => '($data->id_aspecto)',
	 //        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	 //    ),

   		// array(
   		// 	'header' => 'Pr',
	    //     'name'=> 'tbl_Programa_id_programa',
	    //     'value' => '($data->tbl_Programa_id_programa=1)',
	    //     'filter'=>CHtml::listData(Programa::model()->findAll("id_programa=?1",array(1)), 'id_programa', 'nombre'),
	    //     //'value'=>'aspectos::Model()->FindAll($data->tbl_Programa_id_programa)->programa',
	    //     'type'=>'raw',
	    //     'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	    //     'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),

	    // ),

   		array(
		      'header' => 'Nº',
		      'name'=> 'num_aspecto',
		      'type'=>'raw',
		      'value' => '($data->num_aspecto)',
		      'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
	          'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
	       	),
		
		
		// array(
	 //        'name'=> 'tbl_Factor_id_factor',
	 //        'value' => '($data->tbl_Factor_id_factor)',
	 //        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	 //    ),
		
		// array(
	 //        'name'=> 'tbl_caracteristica_id_caracteristica',
	 //        'value' => '($data->tbl_caracteristica_id_caracteristica)',
	 //        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	 //    ),
		
		
		array(
		        'header' => 'Aspecto',
		        'name'=> 'aspecto',
		        'type'=>'raw',
		        'value' => '($data->aspecto)',
		        //'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span7'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				
		    ),

		array(
		        'header' => 'Instrumento',
		        'name'=> 'instrumento',
		        'type'=>'raw',
		        'value' => '($data->instrumento)',
		        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				
		    ),
		
		array(
		        'header' => 'Fuente',
		        'name'=> 'fuente',
		        'type'=>'raw',
		        'value' => '($data->fuente)',
		        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				
		    ),

		array(
		        'header' => 'Documento',
		        'name'=> 'documento',
		        'type'=>'raw',
		        'value' => '($data->documento)',
		        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span3'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				
		    ),

		array(
			 'header' => 'Link',
		     'name'=> 'link',
		     'type'=>'raw',
		     'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span4'),
	         'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
		     'value' => '($data->link)',
		     'class' => 'bootstrap.widgets.TbEditableColumn',
		        'editable' => array(
					'type'    => 'textarea',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)

			),


		array(
		        'header' => 'Observaciones',
		        'name'=> 'Observaciones',
		        'type'=>'raw',
		        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span4'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
		        'value' => '($data->Observaciones)',
		  //       'class' => 'bootstrap.widgets.TbEditableColumn',
		  //       'editable' => array(
				// 	'type'    => 'textarea',
				// 	'url'     => $this->createUrl('editable'),
				// 	'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				// )
		        			
		    ),


		array(
		        'header' => 'cumple',
		        'name'=> 'cumple',
		        'type'=>'raw',
		        'value' => '($data->cumple)',
		        'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span4'),
	        	'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
				
		    ),


		//'instrumento',
		//'fuente',
		//'documento',
		//'link',
		//'Observaciones',

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
  //               	'url' => '$data->id_aspecto."|".$data->id_aspecto',              
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

		 // array(
			// 'header' => Yii::t('ses', 'Link'),
   //          'class' => 'bootstrap.widgets.TbJsonButtonColumn',
			// //'class'=>'bootstrap.widgets.TbButtonColumn',
			// 'template'=>'{poslink}',
			// 'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
			// 'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),

			// 'buttons'=>array(

			// 	'poslink' => array(
   //                  'label'=>'<i class="fa fa-link"></i>',     // text label of the button
   //                  'htmlOptions'=> array('onclick' => 'addtolist()'),                 
   //                  'options'=>array('title'=>'Mostrar Link'), // put here the title to show when mouse over

   //                  'url' => '$data->id_aspecto."|".$data->id_aspecto',              
   //              	'click' => 'function(){
   //              		data=$(this).attr("href").split("|")
   //              		$("#myModalHeader").html(data[1]);
	  //       			$("#myModalBody").load("'.$this->createUrl('view').'&id="+data[0]+"&asModal=true");
   //              		$("#myModal").modal();
   //              		return false;
   //              	}', 

                    
   //              ),
			// ),	
			
			// ),
		

		// array(
  //           'header' => Yii::t('ses', 'Editar'),
  //           'headerHtmlOptions' => array('style' => 'text-align:center;','class'=>'span1'),
  //           'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
  //           'class' => 'bootstrap.widgets.TbJsonButtonColumn',
  //           'template' => '{view}',
  //           	'buttons'=>array (
		// 	        'update'=> array(
		// 	        	 'options'=>array( 'class'=>'icon-edit','title'=>'Actualizar Aspecto'),

		// 	        	),

		// 	        'view'=>array(
		// 	            'options'=>array( 'class'=>'icon-search','title'=>'Ver Aspecto' ),
		// 	        ),
  //      		 ),

  //           ),




	),
)); ?>

</div>

<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal')

); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h2>Link del documento</h2>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>

       <div class="alert alert-info" role="alert">
    
	    <div class="jumbotron" >
	        <table class="table table-bordered">

		    <div class="form">

		 			
	   

			</div><!-- form -->
			</table>
		</div>
	</div>
		
		 
 
    <div class="modal-footer">
        <?php  $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => 'Cerrar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
                'type' => 'primary',
            )
        ); ?>

        
    </div>


 
<?php  $this->endWidget(); ?>
