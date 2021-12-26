<?php

use yii\helpers\Url;

$menuItems =
[



[
   'visible' => !Yii::$app->user->isGuest,
   'label' => 'User / Group',
   'icon' => 'users',
   'url' => '#',
   'items' => [
['label' => 'App. Route', 'icon' => 'external-link', 'url' => ['/route/'], 'visible' => !Yii::$app->user->isGuest],
['label' => 'Role', 'icon' => 'users', 'url' => ['/role/'], 'visible' => !Yii::$app->user->isGuest],
['label' => 'User', 'icon' => 'users', 'url' => ['/user/'], 'visible' => !Yii::$app->user->isGuest],
], ],

];


if (!Yii::$app->user->isGuest) {
    if (Yii::$app->user->identity->username !== 'admin') {
        $menuItems = Mimin::filterMenu($menuItems);
    }
}

?>
<nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Navigation</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-menu pcoded-trigger">
                                    <a href="<?=Url::to(["/"])?>">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="pcoded-item pcoded-left-item">
                
                                <?php echo app\widgets\Menu::widget(
    [
                'items' => $menuItems,
            ]

            //Menus::menuItems()
); ?>
                            </ul>  

                  
          </div>
                    </nav>
                  