<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\SignUpForm $model */
/** @var ActiveForm $form */

$this->title = 'Sign up';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-sign-up">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'sign-up-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-6 col-form-label mr-lg-6'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

                <?= $form->field(model: $model, attribute: 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field(model: $model, attribute: 'password')->passwordInput() ?>

                <?= $form->field(model: $model, attribute: 'passwordConfirm')->passwordInput() ?>

                <div class="form-group">
                    <br />
                    <?= Html::submitButton(content: 'Sign up', options: ['class' => 'btn btn-primary']) ?>
                </div>

                <br />
                <p>
                    <?= Html::a(
                        text: 'Login',
                        url: ['/login'],
                        options: ['class' => 'btn btn-secondary btn-sm'],
                    ) ?>
                </p>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
