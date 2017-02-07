<?php 

class ChangeForm extends CFormModel
{
	public $password;
	public $password_new;
	public $password_new_repeat;

	public function rules()
	{
		return array(
			array('password','password_new','password_new_repeat','required'),
			array('password_new', 'compare'),
			array('password','verify'),
			);
	}

	public function verify($attribute, $params)
	{
		$model=Usuario::model()->findByPk(Yii::app()->user->id);
		if ($model->password !== MD5($this->password)) 
		{
			$this->addError('password','Contraseña incorrecta');
		}
	}

	public function attributeLabels()
	{
		return array(
			'password'=>'Contraseña',
			'password_new'=>'Nueva contraseña',
                        'password_new_repeat'=>'Confirmar contraseña',		
			);
	}

	public function change()
	{
        if(!$this->hasErrors())
        {
            $model=Usuario::model()->findByPk(Yii::app()->user->id);
            $model->password = MD5($this->password_new);
            return $model->save();
        }
        return false;
	}

}

