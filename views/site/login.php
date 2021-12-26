<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">



            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
          
      <div class="text-center">
                                <img src="<?=Url::to(['libraries/assets/images/logo.png'])?>" alt="logo.png">
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Sign In</h3>
                                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

                                            
                                        </div>
                                    </div>
                                    
                                    <div class="form-group form-primary">
                                        <input type="text" name="LoginForm[username]" class="form-control"  placeholder="Username">
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="LoginForm[password]" class="form-control"  placeholder="Password">
                                        <span class="form-bar"></span>
                                    </div>
                                <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
                                        </div>
                                    </div>
                                    <hr>
                                  <?php ActiveForm::end(); ?>
  </div>
