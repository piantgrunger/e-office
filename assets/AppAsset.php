<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

     "https://fonts.googleapis.com/css?family=Open+Sans:400,600",
     'https://use.fontawesome.com/releases/v5.7.2/css/all.css',
   
    "libraries/assets/icon/themify-icons/themify-icons.css",
   "libraries/assets/icon/icofont/css/icofont.css",
   "libraries/assets/icon/feather/css/feather.css",
        
        'libraries/bower_components/bootstrap/css/bootstrap.min.css',
        'libraries/assets/css/style.css',
       //'template/dist/css/style.css',
        //'css/spinners.css',

        'libraries/assets/css/jquery.mCustomScrollbar.css',

    ];
    public $js = [
      'js/yii_overrides.js',
//"libraries/bower_components/jquery/js/jquery.min.js",
   "libraries/bower_components/jquery-ui/js/jquery-ui.min.js",
       "libraries/bower_components/popper.js/js/popper.min.js",
   "libraries/bower_components/bootstrap/js/bootstrap.min.js",
"libraries/bower_components/jquery-slimscroll/js/jquery.slimscroll.js",
       "libraries/bower_components/modernizr/js/modernizr.js",
       'libraries/assets/js/jquery.mCustomScrollbar.concat.min.js',
     "libraries/assets/js/SmoothScroll.js",
    "libraries/assets/js/pcoded.min.js",
 
       "libraries/assets/js/vartical-layout.min.js",

       "libraries/assets/pages/dashboard/custom-dashboard.js",
       "libraries/assets/js/script.min.js",
    ];
    public $depends = [
       'yii\web\YiiAsset',
  //  'yii\bootstrap4\BootstrapAsset',
//    'rmrevin\yii\fontawesome\AssetBundle',
        //additional import of third party alert project
       'app\assets\SweetAlertAsset',
    ];
}
