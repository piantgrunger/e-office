<?php

namespace app\models\settings;

use Yii;
use app\models\User;

/**
 * This is the model class for table "modules".
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property string $name_db
 * @property string $view_col
 * @property string $model
 * @property string $controller
 * @property string $fa_icon
 * @property int $is_gen
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ModuleFields[] $moduleFields
 * @property RoleModule[] $roleModules
 */
class Modules extends \yii\db\ActiveRecord {

    public $acc_view, $acc_create, $acc_edit, $acc_delete, $comp_view;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'modules';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'fa_icon', 'url'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['label', 'url'], 'string', 'max' => 100],
            [['fa_icon'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'label' => Yii::t('app', 'Label'),
            'name_db' => Yii::t('app', 'Name Db'),
            'view_col' => Yii::t('app', 'View Col'),
            'model' => Yii::t('app', 'Model'),
            'controller' => Yii::t('app', 'Controller'),
            'fa_icon' => Yii::t('app', 'Fa Icon'),
            'is_gen' => Yii::t('app', 'Is Gen'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleFields() {
        return $this->hasMany(ModuleFields::className(), ['module' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleModules() {
        return $this->hasMany(RoleModule::className(), ['module_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ModulesQuery the active query used by this AR class.
     */
    public static function find() {
        return new ModulesQuery(get_called_class());
    }

    public function getRoleModule($id = 0) {
        
    }

    public static function hasAccess($module_id, $access_type = "view", $user_id = 0) {
        $roles = array();
        if (is_numeric($module_id)) {
            $module_id = $module_id;
        } else {
            $module = Modules::find()
                    ->where(['name' => $module_id])
                    ->one();
            $module_id = $module->id;
        }

        if ($access_type == null || $access_type == "") {
            $access_type = "view";
        }
        if ($user_id) {
            $user_id = User::findOne(['id' => $user_id]);
            $role_id = $user_id->role_id;
        } else {
            $role_id = yii::$app->user->identity->role_id;
        }
        $roleUser = (new \yii\db\Query())
                ->from('role_module')
                ->where([
                    'role_id' => $role_id,
                    'module_id' => $module_id,
                    'acc_' . $access_type => 1
                ])
                ->one();

        if (!empty($roleUser)) {
            return true;
        }
        return false;
    }

    public static function hasVisible($module_id, $access_type = "view", $user_id = 0) {
        $roles = array();

        if (is_numeric($module_id)) {
            $module_id = $module_id;
        } else {
            $module = Modules::find()
                    ->where(['name' => $module_id])
                    ->one();
            $module_id = $module->id;
        }

        if ($access_type == null || $access_type == "") {
            $access_type = "view";
        }

        if ($user_id) {
            $user_id = \backend\models\Usersa::findOne(['id' => $user_id]);
            $user_id = $user_id->role_id;
        } else {
            $user_id = yii::$app->user->identity->role_id;
        }

        $roleUser = (new \yii\db\Query())
                ->from('role_module')
                ->where([
                    'role_id' => $user_id,
                    'module_id' => $module_id,
                    'acc_' . $access_type => 1
                ])
                ->one();

        if (empty($roleUser)) {
            return 'hidden';
        }
        return '';
    }

    public static function hasVisiblex($module_id, $access_type = "view", $user_id = 0) {
        $roles = array();

        if (is_numeric($module_id)) {
            $module_id = $module_id;
        } else {
            $module = Modules::find()
                    ->where(['name' => $module_id])
                    ->one();
            $module_id = $module->id;
        }

        if ($access_type == null || $access_type == "") {
            $access_type = "view";
        }

        if ($user_id) {
            $user_id = \backend\models\Usersa::findOne(['id' => $user_id]);
            $user_id = $user_id->role_id;
        } else {
            $user_id = yii::$app->user->identity->role_id;
        }

        $roleUser = (new \yii\db\Query())
                ->from('role_module')
                ->where([
                    'role_id' => $user_id,
                    'module_id' => $module_id,
                    'acc_' . $access_type => 1
                ])
                ->one();

        if (!empty($roleUser)) {
            if ($access_type == 'edit') {
                $access_type = 'update';
            }
            return '{' . $access_type . '}';
        }
        return '';
    }

}
