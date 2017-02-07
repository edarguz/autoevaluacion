<?php

class AspectosController extends Controller
{


	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
		
	public $layout='//layouts/column1';		
		/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
						
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
						
		);
	}
	
		/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','editable','cargarcaracteristica','cargarprograma'),
				'users'=>array('@'),
				//'roles'=>array('admin'),
				
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
				'roles'=>array('admin'),
				//'roles'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','export','import','editable','toggle','cargarcaracteristica',),
				'roles'=>array('admin'),
				//'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
		
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		if(isset($_GET['asModal'])){
			$this->renderPartial('view',array(
				'model'=>$this->loadModel($id),
			));
		}
		else{
						
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
			
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
				
		$model=new Aspectos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Aspectos']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$messageType='warning';
				$message = "There are some errors ";
				$model->attributes=$_POST['Aspectos'];
				//$uploadFile=CUploadedFile::getInstance($model,'filename');
				if($model->save()){
					$messageType = 'success';
					$message = "<strong> Se han guardado los datos!</strong> satisfactoriamente ";
					/*
					$model2 = Aspectos::model()->findByPk($model->id_aspecto);						
					if(!empty($uploadFile)) {
						$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
						if(!empty($uploadFile)) {
							if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'aspectos'.DIRECTORY_SEPARATOR.$model2->id_aspecto.DIRECTORY_SEPARATOR.$model2->id_aspecto.'.'.$extUploadFile)){
								$model2->filename=$model2->id_aspecto.'.'.$extUploadFile;
								$model2->save();
								$message .= 'and file uploded';
							}
							else{
								$messageType = 'warning';
								$message .= 'but file not uploded';
							}
						}						
					}
					*/
					$transaction->commit();
					Yii::app()->user->setFlash($messageType, $message);
					$this->redirect(array('view','id'=>$model->id_aspecto));
				}				
			}
			catch (Exception $e){
				$transaction->rollBack();
				Yii::app()->user->setFlash('error', "{$e->getMessage()}");
				//$this->refresh();
			}
			
		}

		$this->render('create',array(
			'model'=>$model,
					));
		
				
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Aspectos']))
		{
			$messageType='warning';
			$message = "There are some errors ";
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Aspectos'];
				$messageType = 'success';
				$message = "<strong> Se han guardado los datos!</strong> satisfactoriamente ";

				/*
				$uploadFile=CUploadedFile::getInstance($model,'filename');
				if(!empty($uploadFile)) {
					$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
					if(!empty($uploadFile)) {
						if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'aspectos'.DIRECTORY_SEPARATOR.$model->id_aspecto.DIRECTORY_SEPARATOR.$model->id_aspecto.'.'.$extUploadFile)){
							$model->filename=$model->id_aspecto.'.'.$extUploadFile;
							$message .= 'and file uploded';
						}
						else{
							$messageType = 'warning';
							$message .= 'but file not uploded';
						}
					}						
				}
				*/

				if($model->save()){
					$transaction->commit();
					Yii::app()->user->setFlash($messageType, $message);
					$this->redirect(array('view','id'=>$model->id_aspecto));
				}
			}
			catch (Exception $e){
				$transaction->rollBack();
				Yii::app()->user->setFlash('error', "{$e->getMessage()}");
				// $this->refresh(); 
			}

			$model->attributes=$_POST['Aspectos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_aspecto));
		}

		$this->render('update',array(
			'model'=>$model,
					));
		
			}


	public function actionCargarcaracteristica()
	{
		$list=Caracteristica::model()->findAll("tbl_Factor_id_factor=?",array($_POST["Aspectos"]["tbl_Factor_id_factor"]));
		foreach ($list as $data) {
			echo "<option value=\"{$data->id_caracteristica}\">{$data->caracteristicas}</option>";
		}
	}


	public function actionCargarprograma()
	{
		$list=Programa::model()->findAll("tbl_Programa_id_programa=?",array(1));
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// yii::app()->authManager->createRole("normal");
		// yii::app()->authManager->assign("normal",3);

      
      		

		/*
		$dataProvider=new CActiveDataProvider('Aspectos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		
		$model=new Aspectos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Aspectos']))
			$model->attributes=$_GET['Aspectos'];

		$this->render('index',array(
			'model'=>$model,
					));
		
			}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$model=new Aspectos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Aspectos']))
			$model->attributes=$_GET['Aspectos'];

		$this->render('admin',array(
			'model'=>$model,
					));

		
		
			}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Aspectos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Aspectos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Aspectos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='aspectos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionExport()
    {
        $model=new Aspectos;
		$model->unsetAttributes();  // clear any default values


		if(isset($_POST['Aspectos']))
			 $model->attributes = $_POST['Aspectos'];

		$exportType = $_POST['fileType'];
        $this->widget('ext.heart.export.EHeartExport', array(
            'title'=>'Aspectos a evaluar',
            'dataProvider' => $model->search(),
            'filter'=>$model->search($_POST),
            'grid_mode'=>'export',
            'exportType'=>$exportType,
            'columns' => array(
	                
					array(
						'header' => 'Programa',
				        'name'=> 'tbl_Programa_id_programa',
				        'value' => '($data->programa->nombre)',
				     ),

					array(
						'header'=>'Factor',
				        'name'=> 'tbl_Factor_id_factor',
				        'value' => '($data->factor->id_factor)',
				    ),
					
					array(
						'header' => 'Caracteristica',
				        'name'=> 'tbl_caracteristica_id_caracteristica',
				        'value' => '($data->tbl_caracteristica_id_caracteristica)',
				    
				    ),
				    
					array(
				      'header' => 'Nº',
				      'name'=> 'num_aspecto',
				      'value' => '($data->num_aspecto)',
				     ),
					'aspecto',
					'instrumento',
					'fuente',
					'documento',
					'link',
					'Observaciones',
					'cumple',
	            ),
        ));
    }

    /**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionImport()
	{
		
		$model=new Aspectos;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Aspectos']))
		{
			if (!empty($_FILES)) {
				$tempFile = $_FILES['Aspectos']['tmp_name']['fileImport'];
				$fileTypes = array('xls','xlsx'); // File extensions
				$fileParts = pathinfo($_FILES['Aspectos']['name']['fileImport']);
				if (in_array(@$fileParts['extension'],$fileTypes)) {

					Yii::import('ext.heart.excel.EHeartExcel',true);
	        		EHeartExcel::init();
	        		$inputFileType = PHPExcel_IOFactory::identify($tempFile);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($tempFile);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$baseRow = 2;
					$inserted=0;
					$read_status = false;
					while(!empty($sheetData[$baseRow]['A'])){
						$read_status = true;						
						//$id_aspecto=  $sheetData[$baseRow]['A'];
						$tbl_Programa_id_programa=  $sheetData[$baseRow]['B'];
						$tbl_Factor_id_factor=  $sheetData[$baseRow]['C'];
						$tbl_caracteristica_id_caracteristica=  $sheetData[$baseRow]['D'];
						$num_aspecto=  $sheetData[$baseRow]['E'];
						$aspecto=  $sheetData[$baseRow]['F'];
						$instrumento=  $sheetData[$baseRow]['G'];
						$fuente=  $sheetData[$baseRow]['H'];
						$documento=  $sheetData[$baseRow]['I'];
						$link=  $sheetData[$baseRow]['J'];
						$Observaciones=  $sheetData[$baseRow]['K'];

						$model2=new Aspectos;
						//$model2->id_aspecto=  $id_aspecto;
						$model2->tbl_Programa_id_programa=  $tbl_Programa_id_programa;
						$model2->tbl_Factor_id_factor=  $tbl_Factor_id_factor;
						$model2->tbl_caracteristica_id_caracteristica=  $tbl_caracteristica_id_caracteristica;
						$model2->num_aspecto=  $num_aspecto;
						$model2->aspecto=  $aspecto;
						$model2->instrumento=  $instrumento;
						$model2->fuente=  $fuente;
						$model2->documento=  $documento;
						$model2->link=  $link;
						$model2->Observaciones=  $Observaciones;
						$cumple->cumple= $cumple;

						try{
							if($model2->save()){
								$inserted++;
							}
						}
						catch (Exception $e){
							Yii::app()->user->setFlash('error', "{$e->getMessage()}");
							//$this->refresh();
						} 
						$baseRow++;
					}	
					Yii::app()->user->setFlash('success', ($inserted).' row inserted');	
				}	
				else
				{
					Yii::app()->user->setFlash('warning', 'Wrong file type (xlsx, xls, and ods only)');
				}
			}


			$this->render('admin',array(
				'model'=>$model,
			));
		}
		else{
			$this->render('admin',array(
				'model'=>$model,
			));
		}
	}

	public function actionEditable(){
		Yii::import('bootstrap.widgets.TbEditableSaver'); 
	    $es = new TbEditableSaver('Aspectos'); 
			    $es->update();
	}

	public function actions()
	{
    	return array(
        		'toggle' => array(
                	'class'=>'bootstrap.actions.TbToggleAction',
                	'modelName' => 'Aspectos',
        		)
    	);
	}

	
}
