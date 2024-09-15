<?php

declare(strict_types = 1);

namespace backend\models;

use common\models\User;
use yii\base\Model;

class SignUpForm extends Model
{
    public ?string $email = null;

    public ?string $password = null;

    public ?string $passwordConfirm = null;

    public function rules(): array
    {
        return [
            [['email', 'password', 'passwordConfirm'], 'required'],
            ['email', 'email'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'email']],
            ['password', 'string', 'min' => 6, 'max' => 12],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => 'Confirm password',
        ];
    }
}
