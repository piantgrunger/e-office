<?php
namespace app\models;

use app\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class UbahPasswordForm extends Model
{
    public $password;
    public $repeat_password;
    public $old_password;


    /**
     * @var \app\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($config = [])
    {
        $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','repeat_password','old_password'], 'required'],
            [['repeat_password'], 'compare', 'compareAttribute' => 'password'],
            [['old_password'], 'cekPassword'],

            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function cekPassword($attribute, $params)
    {
        if (!$this->_user->validatePassword($this->old_password)){
            $this->addError($attribute, 'Password '.$this->old_password.' yang Diinput Tidak Valid ');
            return false;


        }
    }
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
