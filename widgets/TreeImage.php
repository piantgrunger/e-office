<?php
namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\web\View;
use app\widgets\Assets;
use yii\helpers\ArrayHelper;

/**
 *
 *
 * @author Alfian Naufal
 * @since 1.0
 */
class TreeImage extends \yii\bootstrap\Widget
{
    public $root = 'Root';
    public $icon = 'user';
    public $iconRoot = 'tree-conifer';
    public $nameFieldname = 'name';
    public $idFieldname = 'id';
    public $modelSearchName = 'modelsearch';



    public $query;
    public function init()
    {
        Assets::register($this->getView());
        $this->initTreeView(0);
    }

    public function generate_list($array, $parent_id, $level)
    {
        $arrayFilter =[];
        foreach ($array as $data) {
          $arrayFilter[]=  array_filter($data, function ($row) use ($parent_id) {
                //return $row['parent_id']===$parent_id;
            });
        }
        if (count($arrayFilter) >0) {
            echo Html::beginTag('ul'). "\n";
        }
        foreach ($arrayFilter as $value) {
            echo Html::beginTag('li') . "\n" ;
            echo  Html::a(Yii::t('app', $value[$this->nameFieldname]), ['index',$this->modelSearchName."[parent_id]"=>$value[$this->idFieldname]]);

            $this->generate_list($array, $value[$this->idFieldname], $level+1);

            echo Html::endTag('li') . "\n" ;
        }

        if (count($arrayFilter) >0) {
            echo Html::endTag('ul'). "\n";
        }
    }

    protected function initTreeView($parent_id)
    {
        $icon1 = '<i class="mdi mdi-'.$this->icon.'"></i>';
        $iconRoot = '<i class="mdi mdi-'.$this->iconRoot.'"></i>';
        $dataArray = $this->query->asArray()->all();
        var_dump($dataArray);

        $nodeDepth = $currDepth = $counter = 0;
        echo Html::beginTag('div', ['class' => 'tree']);
        echo Html::beginTag('ul') . "\n" .Html::beginTag('li') . "\n" ;
        echo Html::a(Yii::t('app', $iconRoot.'  '.$this->root), ['index',$this->modelSearchName."[parent_id]"=>0]);   // echo '<a href="#">'.$iconRoot.'  '.$this->root.'</a>' . "\n" ;
        $this->generate_list($dataArray, 0, 1);
        echo Html::endTag('div');
    }
}
