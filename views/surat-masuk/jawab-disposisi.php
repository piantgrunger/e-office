<?php

use yii\helpers\Html;

use yii\bootstrap4\ActiveForm;
use kartik\datecontrol\DateControl;

$this->title = 'Jawab Disposisi';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Disposisi', 'url' => ['index-disposisi']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-create">

   
<div class="card-body">

<?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

    <?= $form->field($model, 'jawaban_disposisi')->textArea(['lines'  => 6  ])?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
