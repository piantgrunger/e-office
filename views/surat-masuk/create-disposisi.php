<?php

use yii\helpers\Html;

use yii\bootstrap4\ActiveForm;
use kartik\datecontrol\DateControl;

$this->title = 'Disposisi Baru';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Disposisi', 'url' => ['index-disposisi']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-create">

   
<div class="card-body">

<?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

    <?= $form->field($model, 'catatan_disposisi')->textArea(['lines'  => 6  ])?>

<table id="table-shift" class="table table-hover kv-grid-table kv-table-wrap">
    <thead>
        <tr>

         <th>Tujuan Disposisi</th>
            <th><button id="btn-add2" class="btn btn-primary btn-sm "><i class="fas fa-plus"> </i> Tambah</button></th>
         
          
        </tr>
    </thead>

    <?= \mdm\widgets\TabularInput::widget([
        'id' => 'detail-grid',
        'allModels' => $disposisiDetails,
        'model' => \app\models\DisposisiDetail::className(),
        'tag' => 'tbody',
        'form' => $form,
        'itemOptions' => ['tag' => 'tr'],
        'itemView' => '_item',
        'clientOptions' => [
            'btnAddSelector' => '#btn-add2',
        ]
    ]);
    ?>

    <tfoot>

    </tfoot>

</table>
</div>
</div>

</div>


    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
