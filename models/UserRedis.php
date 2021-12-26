<?php
namespace app\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * Login form.
 */
class UserRedis  extends  \yii\redis\ActiveRecord implements IdentityInterface
{
      const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

  
    public static function primaryKey()
  {
    return ['username'];
  }
  
      public function attributes()
    {
         return [
                   'username',
           'auth_key',
           'password_hash',
            'password_reset_token',
            'email'	,
            'status',
            'created_at',
            'updated_at',
            'id_pegawai',
            'id_satuan_kerja',
            'role_id',
            'id_ruang',
            'telegram_id',
            'deviceId',
            'deviceName',
           
         ];
        
        
    }   
  
   public function rule()
   {
         return [
           [
           [
           'username',
           'auth_key',
           'password_hash',
            'password_reset_token',
            'email'	,
            'status',
            'created_at',
            'updated_at',
            'id_pegawai',
            'id_satuan_kerja',
            'role_id',
            'id_ruang',
            'telegram_id',
            'deviceId',
            'deviceName',

           ],'string']
         ];
     
     
   }
   /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
  
  
  
    public function generateDeviceId($deviceName)
    {
           $this->deviceId = Yii::$app->security->generateRandomString();
           $this->deviceName = $deviceName;
           $this->save(false);
          
        
      
    }


    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(AuthAssignment::className(), [
            'user_id' => 'id',
        ]);
    }

    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function getNama_pegawai()
    {
        return is_null($this->pegawai) ? '' : $this->pegawai->nama_lengkap;
    }
    public function getNip()
    {
        return is_null($this->pegawai) ? '' : $this->pegawai->nip;
    }

    public function getSatuan_kerja()
    {
        return $this->hasOne(SatuanKerja::className(), ['id_satuan_kerja' => 'id_satuan_kerja']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */

    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getIs_atasan()
    {
        if (!is_null($this->pegawai)) {
            return $this->pegawai->is_atasan;
        } else {
            return false;
        }
        //$banding = Banding::find()->select('id_atasan')->where(['id_' => $this->id_pegawai])->one();

     //   return !is_null($banding);
    }

    public function getIs_pimpinan()
    {
        if (!is_null($this->pegawai)) {
            return $this->pegawai->is_pimpinan;
        } else {
            return false;
        }
        //$banding = Banding::find()->select('id_atasan')->where(['id_' => $this->id_pegawai])->one();

     //   return !is_null($banding);
    }
}



  

