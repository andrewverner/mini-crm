<?php

/**
 * @var yii\web\View $this
 * @var Ticket $model
 */

use common\models\Ticket;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'mini CRM ticket';
?>
<div class="row">
    <div class="col-lg-12">
        <?php $form = ActiveForm::begin([
            'id' => 'ticket-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field(model: $model, attribute: 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field(model: $model, attribute: 'phone')->textInput(['maxlength' => 11])->label(label: 'Phone 7XXXXXXXXXX') ?>

        <?= $form->field(model: $model, attribute: 'title')->textInput() ?>

        <?= $form->field(model: $model, attribute: 'comment')->textarea() ?>

        <?= $form->field(model: $model, attribute: 'item')->dropDownList(
            items: [
                'Apples' => 'Apples',
                'Oranges' => 'Oranges',
                'Tangerines' => 'Tangerines',
            ]
        ) ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton(content: 'Create a ticket', options: ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
