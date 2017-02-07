<?php

/**
 * This is the model class for table "tbl_planmejoramiento".
 *
 * The followings are the available columns in table 'tbl_planmejoramiento':
 * @property integer $id_plan
 * @property string $tbl_factor_id_factor
 * @property string $nombre_responsable
 * @property string $cargo
 * @property string $dependencia
 * @property string $telefono
 * @property string $email
 * @property string $nombre_actividad
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $peso
 * @property integer $indicador
 * @property string $meta
 * @property string $descripcion
 * @property string $recursos
 *
 * The followings are the available model relations:
 * @property TblFactor $tblFactorIdFactor
 */
class Planmejoramiento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_planmejoramiento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_factor_id_factor, nombre_responsable, cargo, dependencia, telefono, email, nombre_actividad, fecha_inicio, fecha_fin, peso, indicador, meta, descripcion, recursos', 'required'),
			array('peso, indicador', 'numerical', 'integerOnly'=>true),
			array('tbl_factor_id_factor', 'length', 'max'=>10),
			array('nombre_responsable', 'length', 'max'=>40),
			array('cargo, telefono, email, nombre_actividad, meta', 'length', 'max'=>30),
			array('dependencia', 'length', 'max'=>50),
			array('recursos', 'length', 'max'=>60),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_plan, tbl_factor_id_factor, nombre_responsable, cargo, dependencia, telefono, email, nombre_actividad, fecha_inicio, fecha_fin, peso, indicador, meta, descripcion, recursos', 'safe', 'on'=>'search'),
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
			'factor' => array(self::BELONGS_TO, 'Factor', 'tbl_Factor_id_factor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_plan' => 'Id Plan',
			'tbl_factor_id_factor' => 'Factor Id Factor',
			'nombre_responsable' => 'Nombre Responsable',
			'cargo' => 'Cargo',
			'dependencia' => 'Dependencia',
			'telefono' => 'Telefono',
			'email' => 'Email',
			'nombre_actividad' => 'Nombre Actividad',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'peso' => 'Peso',
			'indicador' => 'Indicador',
			'meta' => 'Meta',
			'descripcion' => 'Descripcion',
			'recursos' => 'Recursos',
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

		$criteria->compare('id_plan',$this->id_plan);
		$criteria->compare('tbl_factor_id_factor',$this->tbl_factor_id_factor,true);
		$criteria->compare('nombre_responsable',$this->nombre_responsable,true);
		$criteria->compare('cargo',$this->cargo,true);
		$criteria->compare('dependencia',$this->dependencia,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('nombre_actividad',$this->nombre_actividad,true);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('peso',$this->peso);
		$criteria->compare('indicador',$this->indicador);
		$criteria->compare('meta',$this->meta,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('recursos',$this->recursos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Planmejoramiento the static model class
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
        	//$from=DateTime::createFromFormat('d/m/Y',$this->fecha_inicio);
        	//$this->fecha_inicio=$from->format('Y-m-d');
        	
        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('d/m/Y',$this->fecha_fin);
        	//$this->fecha_fin=$from->format('Y-m-d');
        	
        return parent::beforeSave();
    }

    public function beforeDelete () {
		$userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
                                
        return false;
    }

    public function afterFind()    {
         
        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('Y-m-d',$this->fecha_inicio);
        	//$this->fecha_inicio=$from->format('d/m/Y');
        	
        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('Y-m-d',$this->fecha_fin);
        	//$this->fecha_fin=$from->format('d/m/Y');
        	
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
