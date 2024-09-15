<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var backend\models\ResetPasswordForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'reset-password-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field(model: $model, attribute: 'password')->passwordInput(options: ['autofocus' => true]) ?>

            <?= $form->field(model: $model, attribute: 'passwordRepeat')->passwordInput() ?>

            <?= $form->field(model: $model, attribute: 'hash')->hiddenInput()->label(label: false) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton(
                        content: 'Continue',
                        options: ['class' => 'btn btn-primary'])
                    ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
