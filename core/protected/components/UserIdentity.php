<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public $scenario;
    
    public function __construct($username,$password,$scenario=FALSE)
    {
        $this->username=$username;
        $this->password=$password;
        $this->scenario=$scenario;
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
        $user = eUser::model()->findByAttributes(Array('username'=>$this->username));
        if($user===null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else if(!$user->validatePassword($this->password,$this->scenario)){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;            
        } else {
            $this->_id=$user->id;
            $this->username=$user->username;
            $this->errorCode=self::ERROR_NONE;                    
        }
        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }
}