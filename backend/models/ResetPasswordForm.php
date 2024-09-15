<?php

declare(strict_types=1);

namespace backend\models;

use Yii;
use yii\base\Model;

final class ResetPasswordForm extends Model
{
    public ?string $hash = null;
    public ?string $password = null;
    public ?string $passwordRepeat = null;

    public function rules(): array
    {
        return [
            [['hash', 'password', 'passwordRepeat'], 'required'],
            ['password', 'string', 'min' => 6, 'max' => 12],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'hash' => 'Hash',
            'password' => 'Password',
            'passwordRepeat' => 'Password repeat',
        ];
    }
}
