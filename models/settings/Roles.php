<?php

namespace app\models\settings;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property int $parent
 * @property int $dept
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PermissionRole[] $permissionRoles
 * @property Permissions[] $permissions
 * @property RoleModule[] $roleModules
 * @property RoleModuleFields[] $roleModuleFields
 * @property RoleUser[] $roleUsers
 * @property Departments $dept0
 * @property Roles $parent0
 * @property Roles[] $roles
 */
class Roles extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'roles';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['description', 'name', 'display_name'], 'required'],
            [['parent', 'dept'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name'], 'string', 'max' => 250],
            [['description'], 'string', 'max' => 1000],
            [['name'], 'unique'],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'display_name' => Yii::t('app', 'Display Name'),
            'description' => Yii::t('app', 'Description'),
            'parent' => Yii::t('app', 'Parent'),
            'dept' => Yii::t('app', 'Dept'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getPermissionRoles() {
        return $this->hasMany(PermissionRole::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getPermissions() {
        return $this->hasMany(Permissions::className(), ['id' => 'permission_id'])->viaTable('permission_role', ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getRoleModules() {
        return $this->hasMany(RoleModule::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getRoleModuleFields() {
        return $this->hasMany(RoleModuleFields::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getRoleUsers() {
        return $this->hasMany(RoleUser::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getDept0() {
        return $this->hasOne(Departments::className(), ['id' => 'dept']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getParent0() {
        return $this->hasOne(Roles::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getRoles() {
        return $this->hasMany(Roles::className(), ['parent' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RolesQuery the active query used by this AR class.
     */
    public static function find() {
        return new RolesQuery(get_called_class());
    }

    public static function getRolesModules($id = 0) {
        return Modules::find()
                        ->select('modules.id,modules.name,role_module.acc_view,role_module.acc_create,role_module.acc_edit,role_module.acc_delete')
                        ->leftJoin('role_module', 'role_module.module_id = modules.id AND role_module.role_id = ' . $id)
                        ->all();
    }

}
