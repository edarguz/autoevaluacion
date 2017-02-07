<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public function getID()
    {
        return $this->_id;
    }

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $model=Usuario::model()->findByAttributes(array(
            'usuario'=>$this->username,
        ));

        if($model===null)
        {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else
        {
            if($model->password===md5($this->password))
            {
                $this->errorCode=self::ERROR_NONE;
               // $this->_id=$user->id;
                $this->_id=$model->id;


               
            }
            else
            {
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
        }

		return !$this->errorCode;
	}
}