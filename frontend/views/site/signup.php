<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registar | TechPower';
?>
<div class="site-signup">
    <h1>Registar nova conta</h1>

    <p>Por favor preencha os seguintes campos:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <hr>

                <?= $form->field($model, 'phone') ?>

                <?= $form->field($model, 'address') ?>

                <?= $form->field($model, 'postal_code') ?>

                <?= $form->field($model, 'city') ?>

                <?= $form->field($model, 'country') ?>

                <?= $form->field($model, 'nif') ?> 

                <div class="form-group">
                    <?= Html::submitButton('Registar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
