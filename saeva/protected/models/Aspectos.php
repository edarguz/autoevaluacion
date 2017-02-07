<?php

/**
 * This is the model class for table "tbl_aspectos".
 *
 * The followings are the available columns in table 'tbl_aspectos':
 * @property string $id_aspecto
 * @property string $tbl_Programa_id_programa
 * @property string $tbl_Factor_id_factor
 * @property string $tbl_caracteristica_id_caracteristica
 * @property string $num_aspecto
 * @property string $aspecto
 * @property string $instrumento
 * @property string $fuente
 * @property string $documento
 * @property string $link
 * @property string $Observaciones
 *
 * The followings are the available model relations:
 * @property Caracteristica $tblCaracteristicaIdCaracteristica
 * @property Factor $tblFactorIdFactor
 * @property Programa $tblProgramaIdPrograma
 */
class Aspectos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_aspectos';
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
		$criteria->addInCondition("id_programa", array(3,4,5,6));
		$programa = Programa::model()->findAll($criteria);
			return CHtml::listData($programa,"id_programa","nombre");
		}
	}

	public function getActualizarindex()
	{
		if (yii::app()->user->checkAccess("admin"))  {  
		$programa='../aspectos/index';
		return $programa;
		}
		if (yii::app()->user->checkAccess("Ingenieria"))  {  
		$programa='../aspectos/index?Aspectos[tbl_Programa_id_programa]=1&Aspectos[tbl_Factor_id_factor]=&Aspectos[tbl_caracteristica_id_caracteristica]=&Aspectos[instrumento]=&Aspectos[fuente]=&Aspectos[documento]=&yt0=
		';
		return $programa;
		}
		if (yii::app()->user->checkAccess("Arte"))  {  
		$programa='../aspectos/index?Aspectos[tbl_Programa_id_programa]=2&Aspectos[tbl_Factor_id_factor]=&Aspectos[tbl_caracteristica_id_caracteristica]=&Aspectos[instrumento]=&Aspectos[fuente]=&Aspectos[documento]=&yt0=
		';
		return $programa;
		}
	}
	 
	public function getMenuFactor()
	{
		return CHtml::listData(Factor::model()->findAll(),"id_factor","factor");
	}

	public function getMenuCaracteristica()
	{

		$caracteristicas=Caracteristica::model()->findAll("tbl_Factor_id_factor");
		return CHtml::listData($caracteristicas,"id_caracteristica","caracteristicas");
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_Programa_id_programa, tbl_Factor_id_factor, tbl_caracteristica_id_caracteristica, num_aspecto, aspecto, instrumento', 'required'),
			array('tbl_Programa_id_programa, tbl_Factor_id_factor, tbl_caracteristica_id_caracteristica', 'length', 'max'=>10),
			array('num_aspecto', 'length', 'max'=>20),
			array('instrumento', 'length', 'max'=>128),
			array('fuente, documento, link', 'length', 'max'=>256),
			array('cumple', 'length', 'max'=>2),
			array('Observaciones','safe'),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_aspecto, tbl_Programa_id_programa, tbl_Factor_id_factor, tbl_caracteristica_id_caracteristica, num_aspecto, aspecto, instrumento, fuente, documento, link, Observaciones', 'safe', 'on'=>'search'),
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
			'caracteristica' => array(self::BELONGS_TO, 'Caracteristica', 'tbl_caracteristica_id_caracteristica'),
			'factor' => array(self::BELONGS_TO, 'Factor', 'tbl_Factor_id_factor'),
			'programa' => array(self::BELONGS_TO, 'Programa', 'tbl_Programa_id_programa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_aspecto' => 'Aspecto',
			'tbl_Programa_id_programa' => 'Programa',
			'tbl_Factor_id_factor' => 'Factor',
			'tbl_caracteristica_id_caracteristica' => 'Caracteristica',
			'num_aspecto' => '# Asp.',
			'aspecto' => 'Aspecto',
			'instrumento' => 'Instrumento',
			'fuente' => 'Fuente',
			'documento' => 'Documento',
			'link' => 'Link',
			'Observaciones' => 'Observaciones',
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

		
		$criteria->compare('id_aspecto',$this->id_aspecto,true);
		$criteria->compare('tbl_Programa_id_programa',$this->tbl_Programa_id_programa,true);
		$criteria->compare('tbl_Factor_id_factor',$this->tbl_Factor_id_factor);
		$criteria->compare('tbl_caracteristica_id_caracteristica',$this->tbl_caracteristica_id_caracteristica,true);
		$criteria->compare('num_aspecto',$this->num_aspecto,true);
		$criteria->compare('aspecto',$this->aspecto,true);
		$criteria->compare('instrumento',$this->instrumento,true);
		$criteria->compare('fuente',$this->fuente,true);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('Observaciones',$this->Observaciones,true);
		$criteria->compare('cumple',$this->cumple,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aspectos the static model class
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
