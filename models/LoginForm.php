<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $deviceId;
    public $deviceName;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            [['deviceId','deviceName'],'safe'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
                     
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Kombinasi Username dan Password Salah');
            } 
            
          if(!is_null($user)){
            if(!is_null($user->id_satuan_kerja) && ($user->id_satuan_kerja !=='') ) {
               date_default_timezone_set('Asia/Makassar');
              
               if((date('H:i') <'09:00' || date('H:i') >'15:30') &&
               (date('H:i') <'16:00'))
               {
                 $this->addError($attribute, 'Admin SKPD  Belum bisa login (09:00-15:30 dan di atas pukul 16:00)   ');
                 
               }  
              
              
            }
            if(!is_null($user->id_pegawai) ) {
              if((!is_null($user->deviceId) && $user->deviceId!=='') || (!is_null($this->deviceId) && $this->deviceId!=='')  ) {
                 if($user->deviceId !== $this->deviceId) {
                        //$this->addError($attribute, 'Gadget yang digunakan tidak sesuai atau  sudah pernah dipake user lain  hubungi administrator untuk perubahan gadget');
    
                 } 
                 
                
              } else {
                 $user->generateDeviceId($this->deviceName);
              }
              
              
            } 
            
          }
            
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {        
          
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]].
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
         }
   

        return $this->_user;
    }
}
