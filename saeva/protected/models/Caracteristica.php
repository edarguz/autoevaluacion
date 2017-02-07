<?php

/**
 * This is the model class for table "tbl_caracteristica".
 *
 * The followings are the available columns in table 'tbl_caracteristica':
 * @property string $id_caracteristica
 * @property string $num_caracteristica
 * @property string $caracteristica
 * @property string $detalle
 * @property double $ponderacion
 * @property string $tbl_Factor_id_factor
 *
 * The followings are the available model relations:
 * @property Aspectos[] $aspectoses
 * @property CalificacionCaracteristica[] $calificacionCaracteristicas
 * @property Factor $tblFactorIdFactor
 */
class Caracteristica extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_caracteristica';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_caracteristica, caracteristica, detalle, tbl_Factor_id_factor', 'required'),
			array('num_caracteristica', 'length', 'max'=>64),
			array('caracteristica', 'length', 'max'=>256),
			array('tbl_Factor_id_factor', 'length', 'max'=>10),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_caracteristica, num_caracteristica, caracteristica, detalle, tbl_Factor_id_factor', 'safe', 'on'=>'search'),
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
			'aspectos' => array(self::HAS_MANY, 'Aspectos', 'tbl_caracteristica_id_caracteristica'),
			'calificacionCaracteristica' => array(self::HAS_MANY, 'CalificacionCaracteristica', 'tbl_caracteristica_id_caracteristica'),
			'factor' => array(self::BELONGS_TO, 'Factor', 'tbl_Factor_id_factor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_caracteristica' => 'Id Caracteristica',
			'num_caracteristica' => '# Carac',
			'caracteristica' => 'Caracteristica',
			'detalle' => 'Detalle',
			'tbl_Factor_id_factor' => 'Factor Id Factor',
		);
	}

	public function getCaracteristicas()
        {
                return $this->num_caracteristica.'   '.$this->caracteristica;
        }


    public function getManagers()
        {
                $criteria=new CDbCriteria;
           

                $models = Caracteristica::model()->findAll($criteria);
 
                $list = CHtml::listData($models, 'tbl_caracteristica_id_caracteristica', 'caracteristica');
                
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


		$sort = new CSort();

                  
		$criteria=new CDbCriteria;

		$criteria->compare('id_caracteristica',$this->id_caracteristica,true);
		$criteria->compare('num_caracteristica',$this->num_caracteristica,true);
		$criteria->compare('caracteristica',$this->caracteristica,true);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('tbl_Factor_id_factor',$this->tbl_Factor_id_factor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		    'pagination'=>array('pageSize'=>10)

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Caracteristica the static model class
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
