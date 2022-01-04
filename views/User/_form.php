<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\SwitchInput;
use app\models\SatuanKerja;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$dataSatuanKerja = ArrayHelper::map(
    SatuanKerja::find()
        ->select(['id' => 'id_satuan_kerja', 'nama' => 'nama_satuan_kerja'])
        ->asArray()
        ->all(),
    'id',
    'nama'
);

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

	<?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
    ]); ?>
	        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->


	<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
        'pluginOptions' => [
            'onText' => 'Active',
            'offText' => 'Banned',
        ]
    ]) ?>

<?= $form->field($model, 'id_satuan_kerja')->widget(Select2::className(), [
        'data' => $dataSatuanKerja,
        'options' => ['placeholder' => 'Pilih Satuan Kerja...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>
		<div class="ui divider"></div>
		<?= $form->field($model, 'new_password') ?>
		<?php if (!$model->isNewRecord) { ?>
		<strong> Leave blank if not change password</strong>

		<?= $form->field($model, 'repeat_password') ?>
		<?= $form->field($model, 'old_password') ?>
	<?php } ?>
	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
