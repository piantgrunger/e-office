<?php


use hscstudio\mimin\components\Mimin;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns=[['class' => 'yii\grid\SerialColumn'],
            'kode',
            'nama',
            'keterangan:ntext',

         ['class' => 'app\widgets\grid\ActionColumn',   'template' => Mimin::filterActionColumn([
              'update','delete','view'], $this->context->route),    ],    ];


/* @var $this yii\web\View */
/* @var $searchModel app\models\JenisSuratSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Jenis Surat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-surat-index">


<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]);?>

	<p>
		<?= Html::a('Jenis Surat Baru', ['create'], ['class' => 'btn btn-success']) ?>
	</p>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
          ]);
 ?>
    <?php Pjax::end(); ?>
</div>
