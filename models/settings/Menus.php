<?php

namespace app\models\settings;

use Yii;
use app\models\settings\Modules;


/**
 * This is the model class for table "la_menus".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $icon
 * @property string $type
 * @property int $parent
 * @property int $hierarchy
 * @property string $created_at
 * @property string $updated_at
 */
class Menus extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'la_menus';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'url'], 'required'],
            [['parent', 'hierarchy'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 256],
            [['type'], 'string', 'max' => 20],
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
            'icon' => Yii::t('app', 'Icon'),
            'type' => Yii::t('app', 'Type'),
            'parent' => Yii::t('app', 'Parent'),
            'hierarchy' => Yii::t('app', 'Hierarchy'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return MenusQuery the active query used by this AR class.
     */
    public static function find() {
        return new MenusQuery(get_called_class());
    }

    public static function menuItems() {
        $menus = Menus::find()->where(['parent' => 0])->orderBy('hierarchy ASC')->all();
        $data['options'] = array('class' => 'nav');
        //$menuItem[0] = array('label' => 'MAIN MENU', 'options' => array('class' => 'header'));

        $menuItem[99] = array('label' => 'Dashboard', 'icon' => 'dashboard', 'url' => Yii::$app->homeUrl, 'parent' => 0, 'id' => 0);

        foreach ($menus as $key) {
            $menuItem[$key->id] = Menus::print_menu($key, $key->parent);
        }

      //  die(print_r($menuItem));

        $data['items'] = $menuItem;


        die(print_r($data));

        return $data;
    }

    public static function print_menu($menu, $parent) {
        $childrens = Menus::find()->where(['parent' => $menu->id])->orderBy('hierarchy ASC')->all();
        $menuItem = array();
        if (count($childrens) > 0) {
            foreach ($childrens as $children) {
                $menuItem[$children->id] = Menus::print_menu($children, $children->parent);
            }
        }

        //$userId = Users::getUserId();
        $userId = yii::$app->user->identity->id;



        if ($menu->type == 'module') {

            if (Modules::hasAccess($menu->module_id, "view", $userId)) {
                $visible = true;
            } else {
                $visible = false;
            }
        } else {
            if (Modules::hasAccess($menu->module_id, "view", $userId)) {
                $visible = true;
            } else {
                $visible = false;
            }
        }

        //echo $menu->url;
        if ($menu->url === '#') {
            $url = $menu->url;
        } else {
            $url = [$menu->url];
        }
        $str = array(
            'id' => $menu->id,
            'label' => $menu->name,
            'icon' => $menu->icon,
            'url' => $url,
            'visible' => $visible,
            'parent' => $parent,
            'items' => $menuItem
        );
        return $str;
    }

}
