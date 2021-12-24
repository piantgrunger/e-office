<?php


use hscstudio\mimin\components\Mimin;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\TreeImage;

$gridColumns=[['class' => 'yii\grid\SerialColumn'],
            'kode',
            'nama',
            // 'D_K',
            // 'M_D',

         ['class' => 'yii\grid\ActionColumn',   'template' => Mimin::filterActionColumn([
              'update','delete','view'], $this->context->route),    ],    ];

/* @var $this yii\web\View */
/* @var $searchModel app\models\AkunSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Akun';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akun-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>


    <p> <?php if ((Mimin::checkRoute($this->context->id."/create"))) { ?>        <?=
    Html::a('Akun Baru', ['create','parent_id' => $searchModel->parent_id], ['class' => 'btn btn-success']) ?>
    <?php } ?>    </p>
<div class="row">
    <div class="col-md-4">
  <?=TreeImage::widget([
      'root' =>'Akun',
      'icon' =>'coin',
      'iconRoot' => 'coin',
      'query' => $dataTree,
      'modelSearchName'=>'AkunSearch',
    'nameFieldname'=>'nama',
    'idFieldname' =>'id'

  ])  ?>

    </div>
    <div class="col-md-8">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,

    ]); ?>
    </div>
    </div>
    <?php Pjax::end(); ?>
</div>
