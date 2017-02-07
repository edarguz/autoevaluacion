<?php

/**
 * This is the model class for table "tbl_factor".
 *
 * The followings are the available columns in table 'tbl_factor':
 * @property string $id_factor
 * @property string $num_factor
 * @property string $nombre
 * @property double $ponderacion
 *
 * The followings are the available model relations:
 * @property Aspectos[] $aspectoses
 * @property CalifFactor[] $califFactors
 * @property CalificacionCaracteristica[] $calificacionCaracteristicas
 * @property Caracteristica[] $caracteristicas
 */
class Factor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_factor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_factor, nombre', 'required'),
			array('ponderacion', 'numerical'),
			array('num_factor', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>256),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_factor, num_factor, nombre, ponderacion', 'safe', 'on'=>'search'),
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
			'aspectos' => array(self::HAS_MANY, 'Aspectos', 'tbl_Factor_id_factor'),
			'califFactor' => array(self::HAS_MANY, 'CalifFactor', 'tbl_Factor_id_factor'),
			'calificacionCaracteristica' => array(self::HAS_MANY, 'CalificacionCaracteristica', 'tbl_Factor_id_factor'),
			'caracteristica' => array(self::HAS_MANY, 'Caracteristica', 'tbl_Factor_id_factor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_factor' => 'Id Factor',
			'num_factor' => 'Num Factor',
			'nombre' => 'Nombre',
			'ponderacion' => 'Ponderacion',
		);
	}

	public function getFactor()
        {
                return $this->num_factor.'   '.$this->nombre;
        }


    public function getManagers()
        {
                $criteria=new CDbCriteria;
           

                $models = Factor::model()->findAll($criteria);
 
                $list = CHtml::listData($models, 'id_factor', 'nombre');
                
                return $list;
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

		$criteria->compare('id_factor',$this->id_factor,true);
		$criteria->compare('num_factor',$this->num_factor,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('ponderacion',$this->ponderacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Factor the static model class
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

        
        return parent::beforeSave();
    }

    public function beforeDelete () {
		$userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
                                
        return false;
    }

    public function afterFind()    {
         
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
