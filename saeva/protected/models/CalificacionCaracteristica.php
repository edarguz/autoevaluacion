<?php

/**
 * This is the model class for table "tbl_calificacion_caracteristica".
 *
 * The followings are the available columns in table 'tbl_calificacion_caracteristica':
 * @property string $id_calif_caracteristica
 * @property string $tbl_caracteristica_id_caracteristica
 * @property string $tbl_Factor_id_factor
 * @property string $tbl_Programa_id_programa
 * @property string $fecha
 * @property double $calificacion
 * @property double $evaluacion
 * @property double $logroideal
 * @property double $relacionlogro
 *
 * The followings are the available model relations:
 * @property Programa $tblProgramaIdPrograma
 * @property Factor $tblFactorIdFactor
 * @property Caracteristica $tblCaracteristicaIdCaracteristica
 */
class CalificacionCaracteristica extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_calificacion_caracteristica';
	}


	public function califiCaracteristica(){
    	return ($this->ponderacion * $this->calificacion)/100;
    	
    	
	}

	public function califilogroideal(){
    	return ($this->ponderacion * 5)/100;
    	
	}

	public function califiRelalogroideal(){
    if 	($this->califilogroideal() <> 0) {

     return $this->califiCaracteristica()/$this->califilogroideal();

    } else

      return 0;	
    	
	}

	



	public function getMenuFactor()
	{
		return CHtml::listData(Factor::model()->findAll(),"id_factor","factor");
	}

	/**
	 * @return array validation rules for model attributes.
	 */


	public function getMenuPrograma()
	{
				
		if (yii::app()->user->checkAccess("admin"))  {  
		$programa=Programa::model()->findAll("id_programa");
		return CHtml::listData($programa,"id_programa","nombre");
		}
		if (yii::app()->user->checkAccess("Ingenieria"))  {  
		$programa=Programa::model()->findAll("id_programa=?",array(1));
		return CHtml::listData($programa,"id_programa","nombre");
		}
		if (yii::app()->user->checkAccess("Arte"))  {  
		$programa=Programa::model()->findAll("id_programa=?",array(2));
		return CHtml::listData($programa,"id_programa","nombre");
		}
		if (yii::app()->user->checkAccess("FCSA"))  {  

		$criteria = new CDbCriteria();
		$criteria->addInCondition("id_programa", array(3,4,5));
		$programa = Programa::model()->findAll($criteria);
			return CHtml::listData($programa,"id_programa","nombre");
		}
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_caracteristica_id_caracteristica, tbl_Factor_id_factor, tbl_Programa_id_programa, fecha', 'required'),
			array('ponderacion, calificacion, evaluacion, logroideal, relacionlogro', 'numerical'),
			array('tbl_caracteristica_id_caracteristica, tbl_Factor_id_factor, tbl_Programa_id_programa', 'length', 'max'=>10),
			array('analisis_cualitativo', 'safe'),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_calif_caracteristica, tbl_caracteristica_id_caracteristica, tbl_Factor_id_factor, tbl_Programa_id_programa, fecha, calificacion, evaluacion, logroideal, relacionlogro, analisis_cualitativo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'programa' => array(self::BELONGS_TO, 'Programa', 'tbl_Programa_id_programa'),
			'factor' => array(self::BELONGS_TO, 'Factor', 'tbl_Factor_id_factor'),
			'caracteristica' => array(self::BELONGS_TO, 'Caracteristica', 'tbl_caracteristica_id_caracteristica'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_calif_caracteristica' => 'Id Calif Caracteristica',
			'tbl_caracteristica_id_caracteristica' => 'Caracteristica Id Caracteristica',
			'tbl_Factor_id_factor' => 'Factor Id Factor',
			'tbl_Programa_id_programa' => 'Programa Id Programa',
			'fecha' => 'Fecha',
			'ponderacion' => 'Ponderacion',
			'calificacion' => 'Calificacion',
			'evaluacion' => 'Evaluacion',
			'logroideal' => 'Logroideal',
			'relacionlogro' => 'Relacionlogro',
			'analisis_cualitativo' => 'Analisis Cualitativo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_calif_caracteristica',$this->id_calif_caracteristica,true);
		$criteria->compare('tbl_caracteristica_id_caracteristica',$this->tbl_caracteristica_id_caracteristica);
		$criteria->compare('tbl_Factor_id_factor',$this->tbl_Factor_id_factor);
		$criteria->compare('tbl_Programa_id_programa',$this->tbl_Programa_id_programa);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('ponderacion',$this->ponderacion);
		$criteria->compare('calificacion',$this->calificacion);
		$criteria->compare('evaluacion',$this->evaluacion);
		$criteria->compare('logroideal',$this->logroideal);
		$criteria->compare('relacionlogro',$this->relacionlogro);
		$criteria->compare('analisis_cualitativo',$this->analisis_cualitativo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>40)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CalificacionCaracteristica the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() 
    {
        $userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
		
		if($this->isNewRecord)
        {           
                        						
        }else{
                        						
        }

        
        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('d/m/Y',$this->fecha);
        	//$this->fecha=$from->format('Y-m-d');
        	
        return parent::beforeSave();
    }

    public function beforeDelete () {
		$userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
                                
        return false;
    }

    public function afterFind()    {
         
        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('Y-m-d',$this->fecha);
        	//$this->fecha=$from->format('d/m/Y');
        	
        parent::afterFind();
    }
	
		
	public function defaultScope()
    {
    	/*
    	//Example Scope
    	return array(
	        'condition'=>"deleted IS NULL ",
            'order'=>'create_time DESC',
            'limit'=>5,
        );
        */
        $scope=array();

        
        return $scope;
    }
}
